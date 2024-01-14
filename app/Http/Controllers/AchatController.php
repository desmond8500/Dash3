<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    static function store(){
        // Model::firstOrCreate([
        // Model::Create([
        //     'name' => $this->name,
        // ]);

        // $this->dispatch('close-addModal');
    }

    static function edit($id){

        $article =  Article::find($id);

        // $this->designation = $article->designation;
        // $this->reference = $article->reference;
        // $this->description = $article->description;
        // $this->quantity = $article->quantity;
        // $this->priority_id = $article->priority_id;
        // $this->brand_id = $article->brand_id;
        // $this->provider_id = $article->provider_id;
        // $this->price = $article->price;

    }

    static function update($id){
        $modal =  Model::find(id);

        $modal->name = $this->name;

        $modal->save();

        $this->dispatch('close-editModal');
    }

    static function delete($id){
        $article =  Article::find($id);
        $article->delete();
        $this->dispatch('close-editArticle');
    }
}
