<?php

use Livewire\Volt\Component;

new class extends Component {
    public $invoice_id;
    public $title;

    public function mount($invoice_id)
    {
        $this->invoice = Invoice::findOrFail($invoice_id);
    }

    function with()
    {
        return [ 'invoice' => $this->invoice, ];
    }
}; ?>

<div>
    @livewire('invoice_resume_pdf', ['invoice' => $invoice], key($invoice->id))
</div>
