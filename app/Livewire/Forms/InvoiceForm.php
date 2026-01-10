<?php

namespace App\Livewire\Forms;

use App\Http\Controllers\ErpController;
use App\Models\Invoice;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceForm extends Form
{
    public Invoice $invoice;

    #[Rule('required|integer')]
    public $projet_id;
    public $client_name;
    public $projet_name;
    // #[Validate('nullable|required')]
    public $reference;
    public $invoice_year;
    public $invoice_number;
    #[Validate('required')]
    public $description;
    public $modalite;
    public $note;
    #[Validate('required')]
    public $statut='Nouveau';
    public $tax=0;
    public $remise=0;
    public $favorite = 0;
    public $image;
    public $facture_date;
    public $paydate;

    function store(){
        $this->validate();
        return Invoice::create($this->all());
    }

    function replicate($invoice_id){
        $invoice = Invoice::find($invoice_id);
        $new_invoice = $invoice->replicate();
        $new_invoice->reference = ErpController::getInvoiceReference($invoice->projet);
        $new_invoice->save();

        foreach ($invoice->invoiceSection as $section) {
            $new_section = $section->replicate();
            $new_section->invoice_id = $new_invoice->id;
            $new_section->save();

            foreach ($section->invoiceRow as $row) {
                $new_row = $row->replicate();
                $new_row->invoice_section_id = $new_section->id;
                $new_row->save();
            }
        }
    }

    function set($model_id){
        $this->invoice = Invoice::find($model_id);

        $this->projet_id = $this->invoice->projet_id;
        $this->client_name = $this->invoice->client_name;
        $this->projet_name = $this->invoice->projet_name;
        $this->reference = $this->invoice->reference;
        $this->invoice_number = $this->invoice->invoice_number;
        $this->invoice_year = $this->invoice->invoice_year;
        $this->description = $this->invoice->description;
        $this->modalite = $this->invoice->modalite;
        $this->note = $this->invoice->note;
        $this->statut = $this->invoice->statut;
        $this->tax = $this->invoice->tax;
        $this->remise = $this->invoice->remise;
        $this->favorite = $this->invoice->favorite;
        $this->facture_date = $this->invoice->facture_date;
        $this->paydate = $this->invoice->paydate;
    }

    function update(){
        $this->invoice->update($this->all());
    }

    function delete(){
        if($this->invoice->sections()->count()){
            return 'error';
        }
        $this->invoice->delete();
        return 'success';
    }

    function favorite()
    {
        if ($this->favorite) {
            $this->favorite = 0;
            $message = 'Le devis a été ajouté aux favoris';
        } else {
            $this->favorite = 1;
            $message = 'Le devis a été supprimé des favoris';
        }
        $this->invoice->update($this->only('favorite'));

        LivewireAlert::text($message)
            ->position('top-end')
            ->toast()
            ->success()
            ->show();

        return $this->favorite;
    }
}
