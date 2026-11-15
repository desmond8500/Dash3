<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Installation;
use App\Models\Invoice;
use App\Models\InvoiceAcompte;
use App\Models\InvoiceProposal;
use App\Models\InvoiceSection;
use App\Models\InvoiceSpent;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;

class PDF2Controller extends Controller
{
    static function installations_pdf(int $projet_id)
    {
        // Récupérer les données nécessaires pour le PDF
        $installations = Installation::where('projet_id', $projet_id)->get();
        $projet = $installations->first()->projet ?? null;


        // Générer le PDF à partir d'une vue
        $pdf = Pdf::view('_pdf2.installation_pdf', [
            'installations' => $installations,
            'projet' => $projet,
            ]);

        // Retourner le PDF en téléchargement
        return $pdf->name('installations.pdf');
    }

    static function invoice_pdf(int $invoice_id, $title = 'Facture')
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $sections = InvoiceSection::where('invoice_id', $invoice->id)->get();

        // Générer le PDF à partir d'une vue
        $pdf = Pdf::view('_pdf2.invoice_pdf', [
            'invoice' => $invoice,
            'title' => $title,
            'sections' => $sections,
            ]);

        $pdf->format('a4');
        $pdf->margins(10, 0, 5, 0);

        // $pdf->headerView('pdf.invoice.header');
        $pdf->footerView('_pdf2.invoice.invoice_footer');

        // $pdf->meta(
        // title: 'Invoice #123',
        // author: 'Tyto Services',
        // subject: 'Devis',
        // keywords: 'invoice, Devis',
        // creator: 'Diène',
        // );

        // Retourner le PDF en téléchargement
        return $pdf->name('invoice.pdf');
    }
    static function task_pdf(int $client_id)
    {
        $client = Client::findOrFail($client_id);

        // Générer le PDF à partir d'une vue
        $pdf = Pdf::view('_pdf2.tasks_pdf', [
            'client' => $client,
            'date' => now(),
            ]);

        $pdf->format('a4');
        $pdf->margins(10, 0, 5, 0);

        // $pdf->headerView('pdf.invoice.header');
        $pdf->footerView('_pdf2.invoice.invoice_footer');

        // $pdf->meta(
        // title: 'Invoice #123',
        // author: 'Tyto Services',
        // subject: 'Devis',
        // keywords: 'invoice, Devis',
        // creator: 'Diène',
        // );

        // Retourner le PDF en téléchargement
        return $pdf->name('invoice.pdf');
    }
    static function invoice_resume_pdf(int $invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);

        $pdf = Pdf::view('_pdf2.invoice.invoice_resume_pdf', [
            'invoice' => $invoice,
            'spents' => InvoiceSpent::where('invoice_id', $invoice_id)->get(),
            'acomptes' => InvoiceAcompte::where('invoice_id', $invoice_id)->where('statut', 1)->get(),
            ]);

        $pdf->format('a4');
        $pdf->margins(10, 0, 5, 0);

        // $pdf->footerView('_pdf2.invoice.invoice_footer');

        return $pdf->name('invoice_resume.pdf');
    }

    /**
     *@OA\Get(
     *      path="/api/v1/facture/proposal_pdf/proposal_id/type",
     *      tags={"PDF",},
     *      summary="Resumé de projet",
     *      @OA\Response(
     *          response=200,
     *          description="PDF généré avec succès",
     *       ),
     *     )
     */

    public static function proposal_pdf(int $proposal_id, $type = 'devis')
    {
        $data = static::proposal_data($proposal_id, $type);

        $pdf = Pdf::view('_pdf.facture.proposal_pdf', $data);

        $pdf->format('a4');
        $pdf->margins(10, 5, 5, 5);

        // Retourner le PDF en téléchargement
        return $pdf->name('Resume.pdf');
    }

    public static function proposal_data(int $proposal_id, $type = 'devis'){
        $proposal = InvoiceProposal::find($proposal_id);
        $quotation = Invoice::find($proposal->invoice_id);

        return [
            'logo' => env('APP_LOGO') ?? null,
            'proposal' => $proposal,
            'quotation' => $quotation,
            'date' => Carbon::now(),
            'type' => 'devis',
        ];
    }
}
