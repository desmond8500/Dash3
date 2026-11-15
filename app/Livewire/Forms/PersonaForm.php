<?php

namespace App\Livewire\Forms;

use App\Models\Persona as ModelsPersona;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class PersonaForm extends Form
{
    public ?ModelsPersona $persona = null;

    #[Rule('required|min:2|max:50')]
    public string $firstname;
    #[Rule('nullable|max:50')]
    public string|null $lastname;
    #[Rule('nullable|max:500')]
    public string|null $description= '';
    public TemporaryUploadedFile|string|null $avatar = null;

    public function rules()
    {
        $rules = [
            'firstname' => 'required|min:2',
            'lastname' => 'nullable|max:50',
            'description' => 'nullable|max:500',
        ];

        if ($this->avatar instanceof TemporaryUploadedFile) {
            $rules['avatar'] = 'image|max:2048';
        }

        return $rules;
    }

    function fix(){
        $this->firstname = ucfirst($this->firstname);
        $this->lastname = ucfirst($this->lastname);
    }

    function store(){
        $this->validate();
        $persona = ModelsPersona::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'description' => $this->description,
        ]);

        if ($this->avatar) {
            $this->storeAvatar($persona, $this->avatar);
        }
    }

    function set(int $persona_id){
        $this->persona = ModelsPersona::find($persona_id);
        $this->firstname = $this->persona->firstname;
        $this->lastname = $this->persona->lastname;
        $this->description = $this->persona->description;
        $this->avatar = $this->persona->avatar;
    }

    function update(){
        $this->validate();
        $this->fix();

        $this->persona->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'description' => $this->description,
        ]);

        if ($this->avatar instanceof TemporaryUploadedFile) {
            $this->storeAvatar($this->persona, $this->avatar, true);
        }
    }

    function delete(int $persona_id){
        $persona = ModelsPersona::find($persona_id);

        Storage::disk('public')
            ->deleteDirectory("medias/personas/{$persona_id}");

        $persona->delete();
    }

    public function storeAvatar(
        ModelsPersona $model,
        TemporaryUploadedFile|string|null $avatar,
        bool $delete = false
    ): void {

        if (! $avatar instanceof TemporaryUploadedFile) {
            return;
        }

        $dir = "medias/personas/{$model->id}/avatar";

        if ($delete) {
            Storage::disk('public')->deleteDirectory($dir);
        }

        $filename = time() . '_' . $avatar->getClientOriginalName();

        $avatar->storeAs($dir, $filename, 'public');

        $model->update([
            'avatar' => "storage/$dir/$filename"
        ]);
    }
}
