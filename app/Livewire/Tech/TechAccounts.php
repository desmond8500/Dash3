<?php

namespace App\Livewire\Tech;

use App\Livewire\Tech\Concerns\TechUi;
use App\Models\User;
use App\Support\TechService;
use Illuminate\Validation\Rule;
use Livewire\Component;

/** Comptes techniciens : création, modification, retrait d'accès. */
class TechAccounts extends Component
{
    use TechUi;

    public ?int $editingId = null;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $function = '';

    public function create(): void
    {
        $this->resetForm();
        $this->openModal('techAccount');
    }

    public function edit(int $id): void
    {
        $user = $this->technician($id);
        $this->resetValidation();
        $this->editingId = $user->id;
        $this->firstname = (string) $user->firstname;
        $this->lastname = (string) $user->lastname;
        $this->email = (string) $user->email;
        $this->function = (string) $user->function;
        $this->password = '';
        $this->openModal('techAccount');
    }

    public function save(): void
    {
        $data = $this->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->editingId)],
            'password' => [$this->editingId ? 'nullable' : 'required', 'string', 'min:8'],
            'function' => ['nullable', 'string', 'max:255'],
        ], [], [
            'firstname' => 'prénom',
            'lastname' => 'nom',
            'password' => 'mot de passe',
            'function' => 'fonction',
        ]);

        if ($this->editingId) {
            TechService::updateTechnician($this->technician($this->editingId), $data);
            $this->toast($data['password'] ? 'Compte mis à jour. Le technicien doit se reconnecter.' : 'Compte mis à jour.');
        } else {
            TechService::createTechnician($data);
            $this->toast('Compte technicien créé.');
        }

        $this->closeModal('techAccount');
        $this->resetForm();
        $this->refreshCounters();
    }

    public function revoke(int $id): void
    {
        TechService::revokeTechnician($this->technician($id));
        $this->toast('Accès retiré : le technicien est déconnecté de l\'application.', 'warning');
        $this->refreshCounters();
    }

    /** Déconnecte le téléphone (perdu, changé…) sans retirer l'accès. */
    public function logoutDevices(int $id): void
    {
        $this->technician($id)->tokens()->delete();
        $this->toast('Sessions mobiles fermées.');
    }

    private function technician(int $id): User
    {
        return User::role(config('tech.role'))->findOrFail($id);
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->reset(['editingId', 'firstname', 'lastname', 'email', 'password', 'function']);
    }

    public function render()
    {
        $technicians = User::role(config('tech.role'))
            ->withCount([
                'techTasks' => fn ($q) => $q->where(fn ($w) => $w->whereNull('statut_id')->orWhere('statut_id', '<', 4)),
                'techReports',
                'tokens',
            ])
            ->orderBy('firstname')
            ->get();

        return view('livewire.tech.tech-accounts', ['technicians' => $technicians]);
    }
}
