<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskAPIController extends Controller
{
    /**
     *@OA\Get(
     *      path="/api/v1/tasks",
     *      tags={"Taches"},
     *      summary="Liste des taches",
     *      @OA\Response(
     *          response=200,
     *          description="Les taches ont été récupérés avec succès",
     *       ),
     *     )
     */

    function index(Request $request)
    {
        $perPage = min($request->get('per_page', 10), 100);

        if ($request->search) {
            $tasks = Task::where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->paginate($perPage);
        } else {
            $tasks = Task::paginate($perPage);
        }
        return ResponseController::response(true, 'Les taches ont été récupérés avec succès', $tasks, [
            'current_page' => $tasks->currentPage(),
            'last_page' => $tasks->lastPage(),
            'per_page' => $tasks->perPage(),
            'total' => $tasks->total(),
        ]);
    }
}
