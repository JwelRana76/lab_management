<?php

namespace App\Http\Controllers;

use App\Models\PathologyPatient;
use App\Service\FinanceService;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->baseService = new FinanceService;
    }

    function dueCollection()
    {
        $patients = PathologyPatient::duepatient()->get();
        return view('pages.finance.due_collection', compact('patients'));
    }
    function dueCollectionStore(Request $request, $id)
    {
        $message = $this->baseService->dueCollectionStore($request->all(), $id);
        return redirect()->route('due_collection.index')->with($message);
    }
    function report()
    {
        $columns = [
            ['name' => 'name', 'data' => 'name'],
            ['name' => 'contact', 'data' => 'contact'],
            ['name' => 'grand_total', 'data' => 'grand_total'],
            ['name' => 'paid', 'data' => 'paid'],
            ['name' => 'due', 'data' => 'due'],
            ['name' => 'action', 'data' => 'action'],
        ];
        $patient = $this->baseService->dueCollection();
        if (request()->ajax()) {
            return $patient;
        }
        return view('pages.finance.due_collection', compact('columns'));
    }
}
