<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'worktime' => 'required|decimal:0,1',
            'note' => 'string|nullable|max:255',
            'date' => 'required|string|max:10',
            'is_working' => 'required|boolean',
            'project' => 'string|nullable|max:255',
            'ticket' => 'required|integer',
            'is_podio_updated' => 'required|boolean',
            'worktime_with_coef' => 'decimal:0,1'
        ]);
        $user = Auth::user();

        $timesheet = new Timesheet();
        $timesheet->worktime = $request->worktime;
        $timesheet->note = $request->note === null ? '' : $request->note;
        $timesheet->date = $request->date;
        $timesheet->is_working = $request->is_working;
        $timesheet->project = $request->project === null ? '' : $request->project;
        $timesheet->ticket = $request->ticket;
        $timesheet->is_podio_updated = $request->is_podio_updated;
        $timesheet->worktime_with_coef = $user->coef_low;
        $user->timesheets()->save($timesheet);

        return response()->json([
            'status' => 'success',
            'message' => 'timesheet created successfully',
            'timesheet' => $timesheet,
            'note' => $request->note
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'worktime' => 'required|decimal:0,1',
            'note' => 'string|nullable|max:255',
            'date' => 'required|string|max:10',
            'is_working' => 'required|boolean',
            'project' => 'string|nullable|max:255',
            'ticket' => 'required|integer',
            'is_podio_updated' => 'required|boolean',
            'worktime_with_coef' => 'decimal:0,1'
        ]);

        $timesheet = Timesheet::find($id);
        $timesheet->worktime = $request->worktime;
        $timesheet->note = $request->note === null ? '' : $request->note;
        $timesheet->is_working = $request->is_working;
        $timesheet->project = $request->project === null ? '' : $request->project;
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
        $user = Auth::user();
        if ($timesheet->user_id === $user->id) {
            $timesheet->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'timesheet deleted successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Not authorized',
            ]);
        }
    }
}
