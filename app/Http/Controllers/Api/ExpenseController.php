<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return response()->json($expenses);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'details' =>'required',
            'amount' =>'required',
        ]);

        $data = [];
        $data['details']        = $request->details;
        $data['amount']         = $request->amount;
        $data['expense_date']   = date('d/m/y');

        DB::table('expenses')->insert($data);
    }

    public function show($id)
    {
        $expense = DB::table('expenses')->where('id',$id)->first();
        return response()->json($expense);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'details' =>'required',
            'amount' =>'required',
        ]);

        $data = [];
        $data['details']        = $request->details;
        $data['amount']         = $request->amount;

        DB::table('expenses')->where('id',$id)->update($data);
    }

    public function destroy($id)
    {
        DB::table('expenses')->where('id',$id)->delete();
    }
}
