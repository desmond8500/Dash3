<?php

namespace App\Livewire\Accounting;

use App\Models\Expense;
use App\Models\ExpenseCategories;
use App\Models\ExpenseSpace;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DepensesPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $breadcrumbs;

    public function mount()
    {
        $this->breadcrumbs = array(
            array('name' => 'depenses', 'route' => route('depenses')),
        );
    }
    public function render()
    {
        return view('livewire.accounting.depenses-page',[
            'expenses' => Expense::all(),
            'categories' => ExpenseCategories::all(),
            'spaces' => ExpenseSpace::all(),
        ]);
    }

    // Category
    public int $category_id = 0;
    public string $category_name ="";
    public string $category_description ="";

    function store_category(){
        ExpenseCategories::create([
            'name' => $this->category_name,
            'description' => $this->category_description,
        ]);
        $this->dispatch('close-addExpenseCategory');
    }


    function edit_category(int $category_id){
        $this->category_id = $category_id;

        $category = ExpenseCategories::find($category_id);

        $this->category_name = $category->name;
        $this->category_description = $category->description;
        $this->dispatch('open-editExpenseCategory');
        }

        function update_category(){
            $category = ExpenseCategories::find($this->category_id);

            $category->name = $this->category_name;
            $category->description = $this->category_description;
            $category->save();
            $this->dispatch('close-editExpenseCategory');
    }

    function delete_category(int $category_id){
        $category = ExpenseCategories::find($category_id);
        $category->delete();
    }

    // Space
    public int $space_id = 0;
    public int $space_user_id = 0;
    public string $space_name = "";
    public string $space_type = "";
    public string $space_currency = "F";

    function store_space()
    {
        ExpenseSpace::create([
            'user_id' => Auth::user()->id,
            'name' => $this->space_name,
            'type' => $this->space_type,
            'currency' => "F",
        ]);
        $this->dispatch('close-addExpensespace');
    }


    function edit_space(int $space_id)
    {
        $this->space_id = $space_id;

        $space = ExpenseSpace::find($space_id);

        $this->space_user_id = $space->user_id;
        $this->space_name = $space->name;
        $this->space_type = $space->type;
        $this->dispatch('open-editExpenseSpace');
    }

    function update_space()
    {
        $space = ExpenseSpace::find($this->space_id);

        $space->name = $this->space_name;
        $this->space_user_id = $space->user_id;
        $this->space_name = $space->name;
        $this->space_type = $space->type;
        $space->save();
        $this->dispatch('close-editExpenseSpace');
    }

    function delete_space(int $space_id)
    {
        $space = ExpenseSpace::find($space_id);
        $space->delete();
    }
}
