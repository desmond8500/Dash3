<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Article;
use App\Models\InvoiceAcompte;
use App\Models\InvoiceRow;
use App\Models\InvoiceSection;
use App\Models\InvoiceSpent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Édition d'un devis (comme livewire/erp/invoice-page) : sections, lignes, acomptes, dépenses.
 */
class InvoiceEditAPIController extends Controller
{
    private function notFound(string $what)
    {
        return response()->json(['success' => false, 'message' => "$what introuvable", 'error' => null, 'meta' => null], 404);
    }

    // ------------------------------------------------------------------
    // Sections
    // ------------------------------------------------------------------

    /** @OA\Post(path="/api/v1/invoice_sections", tags={"Invoices"}, summary="Ajouter une section", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créée")) */
    public function storeSection(Request $request)
    {
        $data = $request->validate([
            'invoice_id' => ['required', 'integer', 'exists:invoices,id'],
            'section' => ['required', 'string', 'max:255'],
            'proposition' => ['nullable', 'string'],
        ]);
        $data['ordre'] = (int) InvoiceSection::where('invoice_id', $data['invoice_id'])->max('ordre') + 1;
        $section = InvoiceSection::create($data + ['show' => true, 'status' => false]);

        return response()->json(['success' => true, 'message' => 'Section ajoutée', 'data' => $section, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/invoice_sections/{id}", tags={"Invoices"}, summary="Modifier une section (titre, proposition, affichage, ordre)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function updateSection(Request $request, int $id)
    {
        $section = InvoiceSection::find($id);
        if (! $section) return $this->notFound('Section');
        $section->update($request->validate([
            'section' => ['sometimes', 'required', 'string', 'max:255'],
            'proposition' => ['sometimes', 'nullable', 'string'],
            'show' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'boolean'],
            'ordre' => ['sometimes', 'integer'],
        ]));

        return ResponseController::response(true, 'Section modifiée', $section);
    }

    /** @OA\Delete(path="/api/v1/invoice_sections/{id}", tags={"Invoices"}, summary="Supprimer une section vide", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimée")) */
    public function destroySection(int $id)
    {
        $section = InvoiceSection::find($id);
        if (! $section) return $this->notFound('Section');
        if ($section->rows()->exists()) {
            return response()->json(['success' => false, 'message' => 'Videz la section avant de la supprimer', 'error' => null, 'meta' => null], 422);
        }
        $section->delete();

        return ResponseController::response(true, 'Section supprimée', null);
    }

    /** @OA\Post(path="/api/v1/invoice_sections/{id}/duplicate", tags={"Invoices"}, summary="Dupliquer une section et ses lignes", security={{"sanctum":{}}}, @OA\Response(response=201, description="Dupliquée")) */
    public function duplicateSection(int $id)
    {
        $section = InvoiceSection::with('rows')->find($id);
        if (! $section) return $this->notFound('Section');

        $copy = DB::transaction(function () use ($section) {
            $copy = $section->replicate();
            $copy->section = $section->section . ' (copie)';
            $copy->ordre = (int) InvoiceSection::where('invoice_id', $section->invoice_id)->max('ordre') + 1;
            $copy->save();
            foreach ($section->rows as $row) {
                $r = $row->replicate();
                $r->invoice_section_id = $copy->id;
                $r->save();
            }
            return $copy;
        });

        return response()->json(['success' => true, 'message' => 'Section dupliquée', 'data' => $copy, 'meta' => null], 201);
    }

    // ------------------------------------------------------------------
    // Lignes
    // ------------------------------------------------------------------

    private function rowRules(bool $create): array
    {
        $req = $create ? 'required' : 'sometimes';

        return [
            'invoice_section_id' => [$create ? 'required' : 'sometimes', 'integer', 'exists:invoice_sections,id'],
            'article_id' => ['sometimes', 'nullable', 'integer', 'exists:articles,id'],
            'designation' => [$req, 'string', 'max:255'],
            'reference' => ['sometimes', 'nullable', 'string'],
            'quantite' => ['sometimes', 'integer', 'min:0'],
            'coef' => ['sometimes', 'numeric', 'min:0'],
            'prix' => ['sometimes', 'numeric', 'min:0'],
            'bought' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'priorite_id' => ['sometimes', 'integer', 'between:0,7'],
            'comment' => ['sometimes', 'nullable', 'string'],
        ];
    }

    /**
     * @OA\Post(path="/api/v1/invoice_rows", tags={"Invoices"},
     *      summary="Ajouter une ligne ; avec article_id seul, reprend la désignation, la référence, le prix et la priorité de l'article",
     *      security={{"sanctum":{}}}, @OA\Response(response=201, description="Créée"))
     */
    public function storeRow(Request $request)
    {
        // Ligne créée depuis un article du stock : valeurs reprises de l'article
        if ($request->filled('article_id') && ! $request->filled('designation')) {
            $article = Article::find($request->article_id);
            if ($article) {
                $request->merge([
                    'designation' => $article->designation,
                    'reference' => $request->input('reference', $article->reference),
                    'prix' => $request->input('prix', $article->price ?? 0),
                    'priorite_id' => $request->input('priorite_id', $article->priority_id ?? 1),
                ]);
            }
        }
        $data = $request->validate($this->rowRules(true));
        $row = InvoiceRow::create($data + ['quantite' => 1, 'coef' => 1, 'prix' => 0, 'priorite_id' => 1, 'reference' => $data['reference'] ?? '_']);

        return response()->json(['success' => true, 'message' => 'Ligne ajoutée', 'data' => $row, 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/invoice_rows/{id}", tags={"Invoices"}, summary="Modifier une ligne (quantité, coef, prix, priorité, commentaire…)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifiée")) */
    public function updateRow(Request $request, int $id)
    {
        $row = InvoiceRow::find($id);
        if (! $row) return $this->notFound('Ligne');
        $data = $request->validate($this->rowRules(false));
        if (array_key_exists('reference', $data) && ($data['reference'] === null || $data['reference'] === '')) {
            $data['reference'] = '_';
        }
        $row->update($data);

        return ResponseController::response(true, 'Ligne modifiée', $row);
    }

    /** @OA\Delete(path="/api/v1/invoice_rows/{id}", tags={"Invoices"}, summary="Supprimer une ligne", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimée")) */
    public function destroyRow(int $id)
    {
        $row = InvoiceRow::find($id);
        if (! $row) return $this->notFound('Ligne');
        $row->delete();

        return ResponseController::response(true, 'Ligne supprimée', null);
    }

    // ------------------------------------------------------------------
    // Acomptes et dépenses
    // ------------------------------------------------------------------

    /** @OA\Post(path="/api/v1/invoice_acomptes", tags={"Invoices"}, summary="Ajouter un acompte", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créé")) */
    public function storeAcompte(Request $request)
    {
        $data = $request->validate([
            'invoice_id' => ['required', 'integer', 'exists:invoices,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'montant' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'statut' => ['nullable', 'boolean'],
        ]);
        $acompte = InvoiceAcompte::create($data + ['statut' => false]);

        return response()->json(['success' => true, 'message' => 'Acompte ajouté', 'data' => $acompte, 'meta' => null], 201);
    }

    /** @OA\Delete(path="/api/v1/invoice_acomptes/{id}", tags={"Invoices"}, summary="Supprimer un acompte", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroyAcompte(int $id)
    {
        $acompte = InvoiceAcompte::find($id);
        if (! $acompte) return $this->notFound('Acompte');
        $acompte->delete();

        return ResponseController::response(true, 'Acompte supprimé', null);
    }

    /** @OA\Post(path="/api/v1/invoice_spents", tags={"Invoices"}, summary="Ajouter une dépense", security={{"sanctum":{}}}, @OA\Response(response=201, description="Créée")) */
    public function storeSpent(Request $request)
    {
        $data = $request->validate([
            'invoice_id' => ['required', 'integer', 'exists:invoices,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'montant' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
        ]);
        $spent = InvoiceSpent::create($data);

        return response()->json(['success' => true, 'message' => 'Dépense ajoutée', 'data' => $spent, 'meta' => null], 201);
    }

    /** @OA\Delete(path="/api/v1/invoice_spents/{id}", tags={"Invoices"}, summary="Supprimer une dépense", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimée")) */
    public function destroySpent(int $id)
    {
        $spent = InvoiceSpent::find($id);
        if (! $spent) return $this->notFound('Dépense');
        $spent->delete();

        return ResponseController::response(true, 'Dépense supprimée', null);
    }
}
