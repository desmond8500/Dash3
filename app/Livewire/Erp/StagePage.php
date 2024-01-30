<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\StageForm;
use App\Models\Stage;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StagePage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $breadcrumbs;

    public $stage;
    public StageForm $form;

    function mount($stage_id)
    {
        $stage = Stage::find($stage_id);
        $this->stage = Stage::find($stage_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $stage->building->projet->client->name, 'route' => route('projets', ['client_id' => $stage->building->projet->client->id])),
            array('name' => $stage->building->projet->name, 'route' => route('projet', ['projet_id' => $stage->building->projet->id])),
            array('name' => $stage->building->name, 'route' => route('building', ['building_id' => $stage->building->id])),
            array('name' => $stage->name, 'route' => route('stage', ['stage_id' => $stage->id])),
        );
    }

    public function render()
    {
        return view('livewire.erp.stage-page',[
            'tasks' => Task::where('stage_id', $this->stage->id)->get(),
        ]);
    }
}
