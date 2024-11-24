<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    static function store_logo($dir, $logo){
        $name = $logo->getClientOriginalName();
        $logo->storeAs("public/$dir", $name);

        return "storage/$dir/$name";
    }

    static function update_logo($dir, $logo){
        Storage::disk('public')->deleteDirectory($dir);
        $name = $logo->getClientOriginalName();
        $logo->storeAs("public/$dir", $name);

        return "storage/$dir/$name";
    }
}
