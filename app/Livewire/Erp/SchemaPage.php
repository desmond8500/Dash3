<?php

namespace App\Livewire\Erp;

use App\Models\Item;
use App\Models\schema as ModelsSchema;
use App\Models\SchemaList;
use Livewire\Component;
use Livewire\WithPagination;
use OpenApi\Annotations\Schema;

class SchemaPage extends Component
{
    use WithPagination;
    public $schema_id;
    public $breadcrumbs;
    public $search = '';

    function mount($schema_id)
    {
        $this->schema_id = $schema_id;
        $schema = ModelsSchema::find($schema_id);
        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $schema->building->projet->client->name, 'route' => route('projets', ['client_id' => $schema->building->projet->client->id])),
            array('name' => $schema->building->projet->name, 'route' => route('projet', ['projet_id' => $schema->building->projet->id])),
            array('name' => $schema->building->name, 'route' => route('building', ['building_id' => $schema->building->id])),
            array('name' => "Schema", 'route' => route('schema', ['schema_id' => $schema->id])),
        );
    }

    public function render()
    {
        return view('livewire.erp.schema-page',[
            'schema' => ModelsSchema::find($this->schema_id),
            "items" => Item::search($this->search)->paginate(10),

        ]);
    }

    function add_item($item_id)
    {
        $schema = ModelsSchema::find($this->schema_id);
        $item = Item::find($item_id);

        SchemaList::create([
            'schema_id' => $schema->id,
            'item_id' => $item->id,
            'name' => $item->name,
        ]);
        $this->dispatch('get_list');
    }
}
