<?php

namespace App\Livewire\Forms;

use App\Models\InvoiceRow;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InvoiceRowForm extends Form
{
    public InvoiceRow $row;

    #[Validate('required')]
    public int $invoice_section_id;
    public ?int $article_id = null;
    #[Validate('required')]
    public string $designation;
    #[Validate('numeric')]
    public float $coef = 1;
    #[Validate('required')]
    public string $reference;
    #[Validate('integer')]
    public int $quantite= 1;
    #[Validate('numeric')]
    public float $prix = 0;
    public int $priorite_id=1;
    #[Validate('integer')]
    public int $bought = 0;
    public string|null $comment = null;

    function set(int $row_id)
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
        $this->comment = $this->row->comment;
    }

    function store()
    {
        if (!$this->bought) {
            $this->bought = 0;
        }
        $this->validate();
        $row = InvoiceRow::create($this->all());
        $row->designation = ucfirst($row->designation);
        $this->reset('designation', 'reference', 'quantite', 'prix', 'coef', 'priorite_id', 'article_id', 'bought', 'comment');
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
