<?php

namespace App\Livewire\Forms;

use App\Models\ArticleBrand;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BrandForm extends Form
{
    public Brand $brand;

    #[Validate('required')]
    public $name;
    public $description;
    public $logo;

    function fix(){
        $this->name = ucfirst($this->name);
        $this->description = ucfirst($this->description);
    }

    function store(){
        $this->validate();
        $this->fix();
        $brand = Brand::create($this->all());

        if ($this->logo) {
            $this->storeAvatar($brand, $this->logo);
        }
        $this->reset('name','description', 'logo');
    }

    function set($brand_id){
        $this->brand = Brand::find($brand_id);
        $this->name = $this->brand->name;
        $this->description = $this->brand->description;
        $this->logo = $this->brand->logo;
    }

    function storeAvatar($brand, $logo, $delete = false){
        if (!is_string($this->logo)) {
            $dir = "stock/brands/$brand->id/logo";
            if ($delete) {
                Storage::disk('public')->deleteDirectory($dir);
            }
            $name = $logo->getClientOriginalName();
            $logo->storeAs("public/$dir", $name);

            $brand->logo = "storage/$dir/$name";
            $brand->save();
        }
    }

    function update(){
        $this->fix();
        $this->brand->update($this->all());

        if ($this->logo) {
            $this->storeAvatar($this->brand, $this->logo);
        }
    }

    function delete($id){
        $this->set($id);
        $this->brand->delete();
    }
}
