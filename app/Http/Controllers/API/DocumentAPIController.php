<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\ProjectDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/** Documents d'un projet, de tout type (PDF, images, Office, DWG, archives…) */
class DocumentAPIController extends Controller
{
    private function present(ProjectDoc $d): array
    {
        $ext = strtolower(pathinfo($d->document_path, PATHINFO_EXTENSION));
        $disk = Storage::disk('public');
        $relative = Str::after($d->document_path, 'storage/');

        return [
            'id' => $d->id,
            'projet_id' => $d->projet_id,
            'name' => $d->document_name,
            'extension' => $ext,
            'size' => $disk->exists($relative) ? $disk->size($relative) : null,
            'url' => url($d->document_path),
            'created_at' => $d->created_at,
        ];
    }

    /** @OA\Get(path="/api/v1/projets/{id}/documents", tags={"Documents"}, summary="Documents du projet", security={{"sanctum":{}}}, @OA\Response(response=200, description="Success")) */
    public function index(int $projetId)
    {
        $docs = ProjectDoc::where('projet_id', $projetId)->latest()->get()->map(fn ($d) => $this->present($d));

        return ResponseController::response(true, 'Documents récupérés', $docs);
    }

    /** @OA\Post(path="/api/v1/projet_documents", tags={"Documents"}, summary="Ajouter un document (multipart : file, projet_id, name?)", security={{"sanctum":{}}}, @OA\Response(response=201, description="Ajouté")) */
    public function store(Request $request)
    {
        $request->validate([
            'projet_id' => ['required', 'integer', 'exists:projets,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:51200'], // 50 Mo
        ]);
        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());
        // Pas de fichiers exécutables côté serveur
        if (in_array($ext, ['php', 'phtml', 'phar', 'sh', 'exe', 'bat', 'cmd', 'js', 'html', 'htm', 'svg'], true)) {
            return response()->json(['success' => false, 'message' => "Type de fichier refusé (.$ext)", 'error' => null, 'meta' => null], 422);
        }

        $dir = "erp/projets/{$request->projet_id}/documents";
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . Str::random(6) . ($ext ? ".$ext" : '');
        Storage::disk('public')->putFileAs($dir, $file, $name);

        $doc = ProjectDoc::create([
            'projet_id' => $request->projet_id,
            'document_name' => $request->input('name') ?: $file->getClientOriginalName(),
            'document_path' => "storage/$dir/$name",
        ]);

        return response()->json(['success' => true, 'message' => 'Document ajouté', 'data' => $this->present($doc), 'meta' => null], 201);
    }

    /** @OA\Put(path="/api/v1/projet_documents/{id}", tags={"Documents"}, summary="Renommer un document", security={{"sanctum":{}}}, @OA\Response(response=200, description="Modifié")) */
    public function update(Request $request, int $id)
    {
        $doc = ProjectDoc::find($id);
        if (! $doc) return response()->json(['success' => false, 'message' => 'Document introuvable', 'error' => null, 'meta' => null], 404);
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $doc->update(['document_name' => $data['name']]);

        return ResponseController::response(true, 'Document renommé', $this->present($doc));
    }

    /** @OA\Get(path="/api/v1/projet_documents/{id}/file", tags={"Documents"}, summary="Télécharger le document (via l'API)", security={{"sanctum":{}}}, @OA\Response(response=200, description="Fichier")) */
    public function file(int $id)
    {
        $doc = ProjectDoc::find($id);
        if (! $doc) return response()->json(['success' => false, 'message' => 'Document introuvable', 'error' => null, 'meta' => null], 404);
        $relative = Str::after($doc->document_path, 'storage/');
        if (! Storage::disk('public')->exists($relative)) {
            return response()->json(['success' => false, 'message' => 'Fichier introuvable sur le serveur', 'error' => null, 'meta' => null], 404);
        }
        $ext = pathinfo($relative, PATHINFO_EXTENSION);
        $filename = Str::slug(pathinfo($doc->document_name, PATHINFO_FILENAME)) . ($ext ? ".$ext" : '');

        return Storage::disk('public')->download($relative, $filename);
    }

    /** @OA\Delete(path="/api/v1/projet_documents/{id}", tags={"Documents"}, summary="Supprimer un document", security={{"sanctum":{}}}, @OA\Response(response=200, description="Supprimé")) */
    public function destroy(int $id)
    {
        $doc = ProjectDoc::find($id);
        if (! $doc) return response()->json(['success' => false, 'message' => 'Document introuvable', 'error' => null, 'meta' => null], 404);
        Storage::disk('public')->delete(Str::after($doc->document_path, 'storage/'));
        $doc->delete();

        return ResponseController::response(true, 'Document supprimé', null);
    }
}
