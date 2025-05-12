<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasAnyRole(['superadmin', 'chief', 'supervisor'])) {
            // Chief or Supervisor: see checklists not in draft
            $checklists = Checklist::where('status', '!=', 'draft')
                ->latest()
                ->get();

            $headers = [
                'id',
                'created_at',
                'brand',
                'plate',
                'mirror',
                'disc',
                'jacket',
                'tire',
                'helmet',
                'vehicle_condition',
                'notes',
                'status',
                'chief_approved',
                'supervisor_approved'
            ];
        } else {
            // Regular user: see only own draft checklists
            $checklists = Checklist::where('status', 'draft')
                ->latest()
                ->get();

            $headers = [
                'id',
                'created_at',
                'brand',
                'plate',
                'mirror',
                'disc',
                'jacket',
                'tire',
                'helmet',
                'vehicle_condition',
                'notes',
                'status'
            ];
        }

        $routes = [
            'create' => route('checklist.create'),
            'submit' => route('checklist.submit.all'),
            'edit_base' => url('checklist'),
            'delete_base' => url('checklist'),
            'approval_base' => url('checklist'),
            'revision_base' => url('checklist'),
        ];

        return view('checklist.index', compact('checklists', 'headers', 'routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('checklist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'time' => 'required|date',
            'brand' => 'required|string',
            'plate' => 'required|string',
            'mirror' => 'required|string',
            'disc' => 'nullable|string',
            'jacket' => 'nullable|string',
            'tire' => 'required|string',
            'helmet' => 'required|string',
            'notes' => 'nullable|string',
            // 'status' => 'required|string|in:draft,submitted,waiting,approved',
        ]);

        Checklist::create([
            'created_by' => Auth::id(),
            'time' => now(),
            'brand' => $request->brand,
            'plate' => $request->plate,
            'mirror' => $request->mirror,
            'disc' => $request->disc,
            'jacket' => $request->jacket,
            'tire' => $request->tire,
            'helmet' => $request->helmet,
            'vehicle_condition' => $request->vehicle_condition,
            'notes' => $request->notes,
            'status' => 'draft',
        ]);

        return redirect()->route('checklist.index')->with('status', 'Checklist submitted for approval.');
    }

    public function edit(Checklist $checklist)
    {
        return view('checklist.edit', compact('checklist'));
    }

    public function update(Request $request, Checklist $checklist)
    {
        $request->validate([
            // 'time' => 'required|date',
            'brand' => 'required|string',
            'plate' => 'required|string',
            'mirror' => 'required|string',
            'disc' => 'nullable|string',
            'jacket' => 'nullable|string',
            'tire' => 'required|string',
            'helmet' => 'required|string',
            'notes' => 'nullable|string',
            // 'status' => 'required|string|in:draft,submitted,waiting,approved',
        ]);

        $checklist->update([
            'time' => now(),
            'brand' => $request->brand,
            'plate' => $request->plate,
            'mirror' => $request->mirror,
            'disc' => $request->disc,
            'jacket' => $request->jacket,
            'tire' => $request->tire,
            'helmet' => $request->helmet,
            'vehicle_condition' => $request->vehicle_condition,
            'notes' => $request->notes,
            'status' => 'draft',
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('checklist.index')->with('status', 'Checklist updated successfully.');
    }

    public function destroy(Checklist $checklist)
    {
        if (
            $checklist->created_by !== Auth::id() &&
            !Auth::user()->hasAnyRole(['superadmin', 'chief', 'supervisor'])
        ) {
            abort(403);
        }

        $checklist->delete();

        return redirect()->route('checklist.index')->with('status', 'Checklist deleted successfully.');
    }

    public function submitAll(Request $request)
    {
        if (!Auth::user()->hasAnyRole(['superadmin', 'admin'])) {
            abort(403);
        }

        Checklist::where('status', 'draft')
            ->where('created_by', Auth::id())
            ->update(['status' => 'submitted']);

        return redirect()->route('checklist.index')->with('status', 'All draft checklists submitted.');
    }

    public function approveAll(Request $request)
    {
        // Ensure only chief or supervisor can perform this
        if (!Auth::user()->hasAnyRole(['superadmin', 'chief', 'supervisor'])) {
            abort(403);
        }

        // Determine what field to update based on role
        $updateField = Auth::user()->hasRole('chief') ? 'chief_approved' : 'supervisor_approved';

        Checklist::where('status', 'submitted')
            ->update([$updateField => true]);

        return redirect()->route('checklist.index')->with('status', 'Checklists approved successfully.');
    }

    public function revision(Checklist $checklist)
    {
        if (
            $checklist->created_by !== Auth::id() &&
            !Auth::user()->hasAnyRole(['superadmin', 'chief', 'supervisor'])
        ) {
            abort(403);
        }

        $checklist->update([
            'status' => 'draft',
            'chief_approved' => false,
            'supervisor_approved' => false,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('checklist.index')->with('status', 'Checklist revisioned successfully.');
    }
}
