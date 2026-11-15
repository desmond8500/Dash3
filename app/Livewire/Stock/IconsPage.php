<?php

namespace App\Livewire\Stock;

use App\Http\Controllers\ImageController;
use App\Models\Icon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Tags\Tag;

/**
 * Table d'icônes : chaque icône est liée aux articles par un tag
 * et matérialise les équipements correspondants sur les plans.
 */
class IconsPage extends Component
{
    use WithFileUploads;

    public $search = '';
    public $breadcrumbs;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'Stock', 'route' => route('stock')),
            array('name' => 'Icônes', 'route' => route('icons')),
        );
    }

    public function render()
    {
        return view('livewire.stock.icons-page', [
            'icons' => Icon::orderBy('name')
                ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('tag', 'like', "%{$this->search}%"))
                ->get(),
            'tags' => Tag::all()->pluck('name')->map(fn ($n) => ucfirst($n))->unique()->sort()->values(),
        ]);
    }

    // ---------- Ajout / édition ----------
    public $icon_id;
    public $name;
    public $tag;
    public $tabler;
    public $color = '#1690b7';

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tag' => ['nullable', 'string', 'max:255'],
            'tabler' => ['nullable', 'string', 'max:60', 'regex:/^ti-[a-z0-9-]+$/'],
            'color' => ['nullable', 'string', 'max:20'],
        ];
    }

    function add_icon()
    {
        $this->reset(['icon_id', 'name', 'tag', 'tabler']);
        $this->color = '#1690b7';
        $this->resetValidation();
        $this->dispatch('open-editIcon');
    }

    function edit_icon($id)
    {
        $icon = Icon::find($id);
        if (! $icon) return;
        $this->icon_id = $icon->id;
        $this->name = $icon->name;
        $this->tag = $icon->tag;
        $this->tabler = $icon->tabler;
        $this->color = $icon->color ?? '#1690b7';
        $this->resetValidation();
        $this->dispatch('open-editIcon');
    }

    function save_icon()
    {
        $data = $this->validate();
        if ($this->icon_id) {
            Icon::find($this->icon_id)?->update($data);
        } else {
            Icon::create($data);
        }
        $this->dispatch('close-editIcon');
    }

    function delete_icon($id)
    {
        $icon = Icon::find($id);
        if (! $icon) return;
        Storage::disk('public')->deleteDirectory("stock/icons/{$icon->id}");
        $icon->delete();
    }

    // ---------- Image ----------
    public $image;

    function edit_image($id)
    {
        $this->icon_id = $id;
        $this->reset('image');
        $this->dispatch('open-editIconImage');
    }

    function update_image()
    {
        $this->validate(['image' => ['required', 'image', 'max:2048']]);
        $icon = Icon::find($this->icon_id);
        if ($icon) {
            $icon->image = ImageController::update_logo("stock/icons/{$icon->id}", $this->image);
            $icon->save();
        }
        $this->dispatch('close-editIconImage');
        $this->reset('image');
    }

    function delete_image($id)
    {
        $icon = Icon::find($id);
        if (! $icon) return;
        Storage::disk('public')->deleteDirectory("stock/icons/{$icon->id}");
        $icon->update(['image' => null]);
    }
}
