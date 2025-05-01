<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ChecklistReportExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Checklist::query();

        // Apply date range filter
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('time', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $checklists = $query->latest()->get();

        $headers = ['id', 'time', 'brand', 'plate', 'status', 'chief_approved', 'supervisor_approved'];

        return view('report.index', compact('checklists', 'headers'));
    }

    public function export(Request $request)
    {
        $query = \App\Models\Checklist::query();

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('time', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $checklists = $query->latest()->get();

        return Excel::download(new ChecklistReportExport($checklists), 'checklists.xlsx');
    }
}
