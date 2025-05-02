<?php

namespace App\Livewire\Forms;

use App\Models\Email;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EmailForm extends Form
{
    public Email $mail;

    #[Rule('required')]
    public $email;
    public $client_id;
    public $contact_id;
    public $team_id;
    public $provider_id;

    function store()
    {
        $this->validate();
        Email::create($this->all());
    }

    function set($model_id)
    {
        $this->mail = Email::find($model_id);
        $this->client_id = $this->mail->client_id;
        $this->contact_id = $this->mail->contact_id;
        $this->team_id = $this->mail->team_id;
        $this->provider_id = $this->mail->provider_id;
        $this->email = $this->mail->email;
    }

    function update()
    {
        $this->validate();
        $this->mail->update($this->all());
    }

    function delete($model_id)
    {
        $this->mail = Email::find($model_id);
        $this->mail->delete();
    }
}
