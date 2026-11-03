<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseControlleur extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $expenses = Expense::all();
        return ResponseController::response(true, "Expenses retrieved successfully", $expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $expense = Expense::create($validatedData);

        return ResponseController::response(true, "Expense created successfully", $expense);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::find($id);

        if ($expense) {
            return ResponseController::response(true, "Expense retrieved successfully", $expense);
        } else {
            return ResponseController::response(false, "Expense not found", []);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return ResponseController::response(false, "Expense not found", []);
        }

        $validatedData = $request->validate([
            'amount' => 'sometimes|required|numeric',
            'description' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
        ]);

        $expense->update($validatedData);

        return ResponseController::response(true, "Expense updated successfully", $expense);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::find($id);

        if ($expense) {
            $expense->delete();
            return ResponseController::response(true, "Expense deleted successfully",[]);
        } else {
            return ResponseController::response(false, "Expense not found",[]);
        }
    }
}
