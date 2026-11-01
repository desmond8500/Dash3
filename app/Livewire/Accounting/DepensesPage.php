<?php

namespace App\Livewire\Accounting;

use App\Models\Article;
use App\Models\Expense;
use App\Models\ExpenseCategories;
use App\Models\ExpenseSpace;
use App\Models\ExpenseSpaceUser;
use App\Models\User;
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
    public mixed $breadcrumbs;

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
            'users' => User::all(),
            'articles' => $this->get_articles()
        ]);
    }

    // Category
    public int $category_id = 0;
    public string $category_name ="";
    public string $category_description ="";

    function store_category(){
        $this->validate([
            'category_name' => ['required']
        ]);

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
        $this->validate([
            'category_name' => ['required']
        ]);

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
        $this->validate([
            'space_name' => ['required'],
            'space_type' => ['required'],
        ]);
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
        $this->validate([
            'space_name' => ['required'],
            'space_type' => ['required'],
        ]);

        $space = ExpenseSpace::find($this->space_id);

        $space->name = $this->space_name;
        $space->type = $this->space_type ;
        $space->save();
        $this->dispatch('close-editExpenseSpace');
    }

    function delete_space(int $space_id)
    {
        $space = ExpenseSpace::find($space_id);
        $space->delete();
    }

    // Dépense
    public int $expense_id = 0;
    public int $expense_space_id = 1;
    public int $expense_user_id = 0;
    public int $expense_article_id = 0;
    public int $expense_brand_id = 0;
    public int $expense_provider_id = 0;
    public int $expense_category_id = 0;
    public int $expense_paid_by = 0;

    public int $expense_amount = 0;
    public string $expense_description = "";
    public string $expense_date = "";
    public string $expense_payment_method = "F";
    public string $expense_type = "Commune";
    public string $expense_notes = "";

    function store_expense()
    {
        $this->expense_user_id = Auth::user()->id;

        $this->validate([
            'expense_space_id' => ['required'],
            'expense_user_id' => ['required'],
            'expense_category_id' => ['required'],
            'expense_paid_by' => ['required'],
            'expense_amount' => ['required'],
            'expense_description' => ['required'],
            'expense_date' => ['required'],
            'expense_payment_method' => ['required'],
            'expense_type' => ['required'],
            'expense_notes' => ['required'],
        ]);

        Expense::create([
            'expense_space_id' => 1,
            'user_id' => Auth::user()->id,

            'article_id' => $this->expense_article_id,
            'brand_id' => $this->expense_brand_id,
            'provider_id' => $this->expense_provider_id,

            'category_id' => $this->expense_category_id,
            'paid_by' => $this->expense_paid_by,

            'amount' => $this->expense_amount,
            'description' => $this->expense_description,
            'expense_date' => $this->expense_date,
            'payment_method' => $this->expense_payment_method,
            'expense_type' => $this->expense_type,
            'notes' => $this->expense_notes,
        ]);
        $this->dispatch('close-addExpenseDepense');
    }


    function edit_expense(int $expense_id)
    {
        $this->expense_id = $expense_id;

        $expense = Expense::find($expense_id);

        $this->expense_user_id = $expense->user_id;

        $this->expense_article_id = $expense->article_id;
        $this->expense_brand_id = $expense->brand_id;
        $this->expense_provider_id = $expense->provider_id;
        $this->expense_category_id = $expense->category_id;
        $this->expense_paid_by = $expense->paid_by;

        $this->expense_amount = $expense->amount;
        $this->expense_description = $expense->description;
        $this->expense_date = $expense->expense_date;
        $this->expense_payment_method = $expense->payment_method;
        $this->expense_type = $expense->expense_type;
        $this->expense_notes = $expense->notes;

        $this->dispatch('open-editExpenseDepense');
    }

    function update_expense()
    {
        $expense = Expense::find($this->expense_id);

        $expense->user_id = $this->expense_user_id;

        $expense->article_id = $this->expense_article_id;
        $expense->brand_id = $this->expense_brand_id;
        $expense->provider_id = $this->expense_provider_id;
        $expense->category_id = $this->expense_category_id;
        $expense->paid_by = $this->expense_paid_by;

        $expense->amount = $this->expense_amount;
        $expense->description = $this->expense_description;
        $expense->expense_date = $this->expense_date;
        $expense->payment_method = $this->expense_payment_method;
        $expense->expense_type = $this->expense_type;
        $expense->notes = $this->expense_notes;

        $expense->save();
        $this->dispatch('close-editExpenseDepense');
    }

    function delete_expense(int $expense_id)
    {
        $expense = Expense::find($expense_id);
        $expense->delete();
    }

    // User
    public int $user_id = 0;
    public int $user_space_id = 0;
    public string $role = "admin";

    function add_user_to_space(int $space_id)
    {
        $this->user_space_id = $space_id;
        $this->dispatch('open-addUserToSpace');
    }

    function store_user_to_space()
    {
        $this->validate([
            'user_id' => ['required'],
            'user_space_id' => ['required'],
            'role' => ['required'],
        ]);

        ExpenseSpaceUser::create([
            'user_id' => $this->user_id,
            'expense_space_id' => $this->user_space_id,
            'role' => $this->role,
        ]);
        $this->dispatch('close-addUserToSpace');
    }

    function select_article(int $article_id)
    {
        $this->expense_article_id = $article_id;
    }

    public $article_search = "";

    function get_articles()
    {
        return Article::query()
            // ->when(
            //     $this->brand_id,
            //     fn($q) => $q->where('brand_id', $this->brand_id)
            // )
            ->articleSearch($this->article_search)
            ->orderByDesc('id')
            ->paginate(6);
    }
}
