<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    function getTasks($date){
        $tasks = Task::where('start_date', $date)->get();

        return $tasks;
    }
}
