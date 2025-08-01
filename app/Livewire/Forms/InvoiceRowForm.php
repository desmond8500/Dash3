<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceRow;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceRowForm extends Form
{
    public InvoiceRow $row;

    #[Validate('required')]
    public $invoice_section_id;
    public $article_id;
    #[Validate('required')]
    public $designation;
    #[Validate('numeric')]
    public $coef = 1;
    #[Validate('required')]
    public $reference;
    #[Validate('integer')]
    public $quantite= 1;
    #[Validate('numeric')]
    public $prix = 0;
    public $priorite_id=1;
    #[Validate('integer')]
    public $bought=0;

    function set($row_id)
    {
        $this->row = InvoiceRow::find($row_id);

        $this->invoice_section_id = $this->row->invoice_section_id;
        $this->designation = $this->row->designation;
        $this->article_id = $this->row->article_id;
        $this->coef = $this->row->coef;
        $this->reference = $this->row->reference;
        $this->quantite = $this->row->quantite;
        $this->prix = $this->row->prix;
        $this->priorite_id = $this->row->priorite_id;
        $this->bought = $this->row->bought;
    }

    function store()
    {
        $this->validate();
        $row = InvoiceRow::create($this->all());
        $row->designation = ucfirst($row->designation);
        $this->reset('designation', 'reference', 'quantite', 'prix', 'coef', 'priorite_id', 'article_id', 'bought');
        $row->save();
    }

    function update()
    {
        $this->validate();
        $this->row->update($this->all());

        $this->row->designation = ucfirst($this->row->designation);
        $this->row->save();
    }

    function delete()
    {
        $this->row->delete();
    }
}
