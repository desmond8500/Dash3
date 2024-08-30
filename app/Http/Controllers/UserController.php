<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function users(){
        return [
            'message'=> 'La liste des utilisateurs a été récupéré avec succès',
            'succes' => true,
            'data'=> User::all(),
        ];
    }

    function user_add(Request $request){

    }
    function user_update($id,Request $request){

    }
    function user_delete($id){

    }
    function sign_in(Request $request){

    }
    function sign_out(Request $request){

    }
    function register(Request $request){

    }
    function reset_password(Request $request){

    }
}
