<?php

namespace App\Livewire\Erp;

use App\Models\Facture;
use App\Models\Invoice;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Facturelist extends Component
{
    use WithFileUploads;

    public $invoice;

    #[Validate('required')]
    public $invoice_id;
    // #[Validate('required')]
    public $file;
    #[Validate('required')]
    public $montant;
    #[Validate('required')]
    public $status = 'facture';
    #[Validate('required')]
    public $reference;

    public $folder;
    public $description;
    public $date;
    public $year;
    public $month;
    public $facture;

    function mount($invoice_id)
    {
        $this->invoice_id = $invoice_id;
        $this->invoice = Invoice::find($invoice_id);
        $this->reference = $this->invoice->reference;
        $this->montant = $this->invoice->total();
        $this->description = $this->description ?? $this->invoice->description;
    }

    public function render()
    {
        return view('livewire.erp.facturelist', [
            'factures' => Facture::where('invoice_id', $this->invoice_id)->get(),
        ]);
    }

    function store()
    {
        $this->validate();
        $facture = Facture::create([
            'invoice_id' => $this->invoice_id,
            'folder' => "facture",
            'status' => $this->status ?? 'pending',
            'reference' => $this->reference,
            'description' => $this->description,
            'montant' => $this->montant,
            'date' => $this->date,
        ]);

        $dir = "erp/invoices/$this->invoice_id/factures/";
        $name = $this->file->getClientOriginalName();
        $this->file->storeAS("public/$dir", $name);
        $facture->folder = "storage/$dir/$name";
        $facture->save();


        $this->dispatch('close-addFacture');
    }

    function edit($id)
    {
        $this->facture = Facture::find($id);
        $this->dispatch('open-editFacture');
    }

    function update()
    {
        $this->facture->status = $this->status;
        $this->facture->reference = $this->reference;
        $this->facture->description = $this->description;
        $this->facture->montant = $this->montant;
        $this->facture->date = $this->date;
        $this->facture->status = $this->status;
        $this->facture->save();

        $this->dispatch('close-editFacture');
    }

    function delete($id)
    {
        $facture = Facture::find($id);
        $facture->delete();
    }
}
