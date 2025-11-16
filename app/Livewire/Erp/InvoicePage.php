<?php

namespace App\Livewire\Erp;

use App\Http\Controllers\InvoiceController;
use App\Imports\InvoiceImport;
use App\Livewire\Forms\InvoiceForm;
use App\Livewire\Forms\InvoiceRowForm;
use App\Livewire\Forms\InvoiceSectionForm;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Forfait;
use App\Models\Invoice;
use App\Models\InvoiceModel;
use App\Models\InvoiceRow;
use App\Models\InvoiceSection;
use App\Models\InvoiceSpent;
use App\Models\InvoiceSystem;
use App\Models\Provider;
use App\Models\Pv;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class InvoicePage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public $devis;

    public function mount($invoice_id){
        $this->devis = Invoice::find($invoice_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $this->devis->projet->client->name, 'route' => route('projets', ['client_id' => $this->devis->projet->client->id])),
            array('name' => $this->devis->projet->name, 'route' => route('projet', ['projet_id' => $this->devis->projet->id])),
            array('name' => "Devis", 'route' => route('invoice', ['invoice_id' => $this->devis->id])),
        );

        $this->ordre = InvoiceSection::where('invoice_id', $this->devis->id)->count()+1;
    }

    public function render()
    {
        return view('livewire.erp.invoice-page',[
            'sections' => $this->getSections(),
            // 'systems' => Systeme::all(),
            'systems' => InvoiceSystem::all(),
            'providers' => Provider::all(),
            'brands' => Brand::all(),
            'articles' => Article::search($this->search, 'designation')->paginate(9),
            'pvs' => Pv::where('invoice_id', $this->devis->id)->get(),
            'statuses' => InvoiceController::statut(),
            'forfaits' => Forfait::all(),
            'models' => InvoiceModel::all(),
            'forfaits' => Forfait::where('client_id', $this->devis->projet->client_id)->get(),
        ]);
    }

    // Section
    public $section, $ordre, $section_tab = true;

    public InvoiceSectionForm $section_form;
    public $section_info;

    #[On('invoice-section-reload') ]
    function getSections() {
        return InvoiceSection::where('invoice_id', $this->devis->id)->get();
    }

    function addSection(){
        $this->dispatch('open-addSection');
        $this->section_form->ordre = InvoiceSection::where('invoice_id', $this->devis->id)->count() + 1;
    }

    function sectionStore()
    {
        $this->section_form->invoice_id = $this->devis->id;
        $this->section_form->store();
        $this->ordre++;
        $this->dispatch('close-addSection2');
    }

    function section_generate($name)
    {
        $section = InvoiceSection::create([
            'invoice_id' => $this->devis->id,
            'section' => $name,
            'ordre' => $this->section_form->ordre,
        ]);

        $this->dispatch('close-addSection');
        return $section;
    }

    function edit_section($section_id){
        $this->section_form->set($section_id);
        $this->dispatch('open-editSection');
    }

    function update_section(){
        $this->section_form->update();
        $this->dispatch('close-editSection');
    }
    function delete_section($id)
    {
        $this->message= $this->section_form->delete($id);
        $this->dispatch('open-infoModal');
    }

    function section_model_add($section_model_id, $section_id = 0)
    {
        if (!$section_id) {
            $section_id = InvoiceSection::count() + 1;
        }
        $invoice_model = InvoiceModel::find($section_model_id);
        $section = $this->section_generate($invoice_model->name);

        foreach ($invoice_model->rows as $row) {
            try {
                $iv = InvoiceRow::create([
                    'invoice_section_id' => $section->id,
                    'article_id' => $row->article_id,
                    'designation' => $row->designation,
                    'coef' => $row->coef,
                    'reference' => $row->reference,
                    'prix' => $row->prix,
                    'quantite' => $row->quantite,
                    'priorite_id' => $row->priorite_id,
                ]);

                Debugbar::info('Ligne créée : ' . $iv);
            } catch (\Exception $e) {
                Debugbar::info('Erreur lors de la création de la ligne : ' . $e->getMessage());
            }



        }

        $this->dispatch('open-selectSectionModel');
    }



    function proposition_toggle($section_id)
    {
        $this->section_form->set($section_id);
        $this->section_form->proposition_toggle();
    }



    // Row
    public $row_tab = 1, $row_class = '';
    public InvoiceRowForm $row_form;
    function toggle_row($tab){
        $this->row_tab = $tab;
        if ($this->row_tab == 1) {
            $this->row_class = '';
        } elseif ($this->row_tab == 2) {
            $this->row_class = 'modal-xl';
        } else {
            $this->row_class = 'modal-md';
        }

    }

    function addRow($section_id){
        $this->row_form->invoice_section_id = $section_id;
        $this->dispatch('open-addRow');
    }
    function storeRow(){
        $this->row_form->store();
        $this->dispatch('close-addRow');
    }
    function designation($designation){
        $this->row_form->designation = $designation;
        $this->row_form->reference = $designation;
    }
    function forfait($id){
        $forfait = Forfait::find($id);
        $this->row_form->designation = $forfait->designation;
        $this->row_form->reference = $forfait->description;
        $this->row_form->prix = $forfait->price;

        $this->row_form->article_id = 0; // Reset article_id if forfait is used
        $this->row_form->coef = 1;
        $this->row_form->quantite = 1;
        $this->row_form->priorite_id = 7;


        $this->row_form->store();
    }
    function prix($prix){
        $this->row_form->prix = $prix;
    }

    function generateRow(){
        $this->row_form->store();
        $this->dispatch('close-addRow');
    }

    function setArticleRow($article_id){
        $article = Article::find($article_id);
        $this->row_form->designation = $article->designation;
        $this->row_form->reference = $article->reference;
        $this->row_form->article_id = $article->article_id;
    }
    public $quantity = 1;

    #[On('generateArticleRow')]
    function generateArticleRow($article_id){
        $article = Article::find($article_id);
        $this->row_form->article_id = $article->id;
        $this->row_form->designation = $article->designation;
        $this->row_form->reference = $article->reference;
        $this->row_form->prix = $article->price;

        $this->row_form->store();
        // $this->dispatch('close-addRow');
    }

    function editRow($row_id){
        $this->row_form->set($row_id);
        $this->dispatch('open-editRow');
    }

    function updateRow(){
        $this->row_form->update();
        $this->dispatch('close-editRow');
    }

    function deleteRow($id){
        $row = InvoiceRow::find($id);
        $row->delete();
    }

    // Invoice
    public InvoiceForm $invoice_form;

    function edit($id){
        $this->invoice_form->set($id);
        $this->dispatch('open-editInvoice');
    }

    function update_invoice()
    {
        $this->invoice_form->update();
        $this->devis = Invoice::find($this->devis->id);
        $this->dispatch('close-editInvoice');
    }

    function toggleFavorite()
    {
        if ($this->devis->favorite) {
            $this->devis->favorite = 0;
        } else {
            $this->devis->favorite = 1;
        }
        $this->devis->save();
    }

    // Message
    public $message;
    function info($message){
        $this->message = $message;
        $this->dispatch('open-infoModal');
    }

    function close(){
        $this->dispatch('close-infoModal');
    }

    public $file;
    function import(){
        // $sections = InvoiceSection::where('invoice_id', $this->devis->id)->get();
        Excel::import(new InvoiceImport, $this->file);
    }

    public $modalite;
    function edit_modalite(){
        $this->modalite = $this->devis->modalite;
        $this->dispatch('open-editModalite');
    }
    function update_modalite(){
        $this->devis->modalite = $this->modalite;
        $this->devis->save();
        $this->dispatch('close-editModalite');
    }

    public $note;
    function edit_note(){
        $this->note = $this->devis->note;
        $this->dispatch('open-editNote');
    }
    function update_note(){
        $this->devis->note = $this->note;
        $this->devis->save();
        $this->dispatch('close-editNote');
    }

    function modalite_set($id){
        if ($id == 0) {
            $this->devis->modalite = "";
        } elseif($id == 1){
            $this->devis->modalite = "Paiement du montant du matériel à la commande.  Paiement du reliquat après la réception des travaux";
        }elseif($id == 2){
            $this->devis->modalite = "Acompte de 50% à payer avant les travaux.  Paiement du reliquat après la réception des travaux";
        }
        $this->devis->save();
    }
    function note_set($id){
        if ($id == 0) {
            $this->devis->note = "";
        } elseif($id == 1){
            $this->devis->note = "Paiement du montant du matériel à la commande.  Paiement du reliquat après la réception des travaux";
        }
        $this->devis->save();
    }

    // Procès verbeauxx
    function addPv(){
        Pv::create([
            'invoice_id' => $this->devis->id,
            'date' => Carbon::now(),
        ]);
    }

    function update_status($invoice_id, $status)
    {
        $this->devis->statut = $status;
        $this->devis->save();
    }

    public $section_system_select;

    function section_show($invoice_system_id){
        $this->section_system_select = InvoiceSystem::find($invoice_system_id);
        $this->dispatch('open-selectSectionModel');
    }

    function section_toggle($section_id){
        $section = InvoiceSection::find($section_id);
        if ($section->show) {
            $section->show = false;
        } else {
            $section->show = true;
        }
        $section->save();
        $this->dispatch('invoice-section-reload');
    }



    // Acompte

    function add_to_acompte($row_id){
        $row = InvoiceRow::find($row_id);

        $acompte = InvoiceSpent::create([
            'invoice_id' => $this->devis->id,
            'name' => $row->designation,
            'description' => $row->reference,
            'montant' => $row->prix*$row->quantite,
            'date' => Date::now(),
        ]);

        $this->dispatch('get_invoice_spent');

    }

    // Section
    function duplicate_section($section_id){
        $section = InvoiceSection::find($section_id);

        $new_section = InvoiceSection::create([
            'invoice_id' => $this->devis->id,
            'section' => $section->section . ' (copie)',
            'ordre' => InvoiceSection::where('invoice_id', $this->devis->id)->count() + 1,
        ]);

        foreach ($section->rows as $row) {
            InvoiceRow::create([
                'invoice_section_id' => $new_section->id ,
                'article_id' => $row->article_id,
                'designation' => $row->designation,
                'coef' => $row->coef,
                'reference' => $row->reference,
                'prix' => $row->prix,
                'quantite' => $row->quantite,
                'priorite_id' => $row->priorite_id,
            ]);
        }

        $this->dispatch('invoice-section-reload');
    }
}
