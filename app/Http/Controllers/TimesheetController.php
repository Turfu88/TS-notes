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
            'worktime' => 'required|string|max:255',
            'note' => 'required|string|max:255',
        ]);

        $timesheet = Timesheet::create([
            'worktime' => $request->worktime,
            'note' => $request->note,
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