<?php

namespace App\Exports;

use App\Models\Checklist;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ChecklistReportExport implements FromView
{
    protected $checklists;

    public function __construct($checklists)
    {
        $this->checklists = $checklists;
    }

    public function view(): View
    {
        return view('exports.checklist', [
            'checklists' => $this->checklists
        ]);
    }
}
