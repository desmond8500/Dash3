<?php

namespace App\Livewire\Forms;

use App\Models\Projet;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class ProjetForm extends Form
{
    public Projet $projet;

    #[Rule('required')]
    public string $name = '';

    #[Rule('required')]
    public int $client_id = 0;

    public string $description = '';
    public ?string $start_date = null;
    public ?string $end_date = null;
    public bool $favorite = false;
    #[Validate('nullable|image|max:2048')]
    public TemporaryUploadedFile|string|null $logo = null;


    public function set(int $projet_id): void
    {
        $this->projet = Projet::findOrFail($projet_id);

        $this->fill($this->projet->only([
            'client_id',
            'name',
            'description',
            'start_date',
            'end_date',
            'favorite',
            'logo',
        ]));
    }

    public function store(): void
    {
        $this->validate();

        Projet::create([
            'client_id' => $this->client_id,
            'name' => ucfirst($this->name),
            'description' => ucfirst($this->description),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'favorite' => $this->favorite,
        ]);
    }

    public function update(): void
    {
        $this->validate();

        $this->projet->update([
            'client_id' => $this->client_id,
            'name' => ucfirst($this->name),
            'description' => ucfirst($this->description),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'favorite' => $this->favorite,
        ]);
    }

    public function delete(): void
    {
        $this->projet->delete();

        LivewireAlert::text('Le projet a été supprimé avec succès.')
            ->position('top-end')
            ->toast()
            ->success()
            ->show();
    }

    public function favorite(): bool
    {
        $this->favorite = !$this->favorite;

        $this->projet->update([
            'favorite' => $this->favorite,
        ]);

        $message = $this->favorite
            ? 'Le projet a été ajouté aux favoris .'
            : 'Le projet a été retiré des favoris .';

        LivewireAlert::text($message)
            ->position('top-end')
            ->toast()
            ->success()
            ->show();

        return $this->favorite;
    }

    public function store_logo()
    {
        if (! $this->logo instanceof TemporaryUploadedFile) {
            LivewireAlert::text('Veuillez sélectionner un logo avant de sauvegarder.')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
            return;
        }

        $dir = "erp/clients/{$this->client_id}/projets/{$this->projet->id}/logo";
        $name = $this->logo->getClientOriginalName();

        $this->logo->storeAs("public/$dir", $name);
        $path = "storage/$dir/$name";
        $this->projet->update([
            'logo' => $path,
        ]);
        $this->logo = $path;
    }
}
