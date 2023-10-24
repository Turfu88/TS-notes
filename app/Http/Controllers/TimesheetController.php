<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;

class TimesheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $timesheets = Timesheet::all();
        return response()->json([
            'status' => 'success',
            'timesheets' => $timesheets,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'worktime' => 'required|decimal:0,1',
            'note' => 'required|string|max:255',
            'date' => 'required|string|max:10',
            'is_working' => 'required|boolean',
            'project' => 'required|string|max:255',
            'ticket' => 'required|integer',
            'is_podio_updated' => 'required|boolean',
            'worktime_with_coef' => 'required|decimal:0,1'
        ]);

        $timesheet = Timesheet::create([
            'worktime' => $request->worktime,
            'note' => $request->note,
            'date' => $request->date,
            'is_working' => $request->is_working,
            'project' => $request->project,
            'ticket' => $request->ticket,
            'is_podio_updated' => $request->is_podio_updated,
            'worktime_with_coef' => $request->worktime_with_coef,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'timesheet created successfully',
            'timesheet' => $timesheet,
        ]);
    }

    public function show($id)
    {
        $timesheet = Timesheet::find($id);
        return response()->json([
            'status' => 'success',
            'timesheet' => $timesheet,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'worktime' => 'required|string|max:255',
            'note' => 'required|string|max:255',
        ]);

        $timesheet = Timesheet::find($id);
        $timesheet->worktime = $request->worktime;
        $timesheet->note = $request->note;
        $timesheet->is_working = $request->is_working;
        $timesheet->project = $request->project;
        $timesheet->ticket = $request->ticket;
        $timesheet->is_podio_updated = $request->is_podio_updated;
        $timesheet->worktime_with_coef = $request->worktime_with_coef;
        $timesheet->save();

        return response()->json([
            'status' => 'success',
            'message' => 'timesheet updated successfully',
            'timesheet' => $timesheet,
        ]);
    }

    public function destroy($id)
    {
        $timesheet = Timesheet::find($id);
        $timesheet->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'timesheet deleted successfully',
        ]);
    }
}