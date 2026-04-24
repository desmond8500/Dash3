<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use App\Models\Invoice;
use App\Models\InvoiceSection;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class PDF2Controller extends Controller
{
    static function installations_pdf($projet_id)
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

    static function invoice_pdf($invoice_id, $title = 'Facture')
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
        $pdf->footerView('_pdf2.invoice_footer');

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
}
