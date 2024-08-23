<?php
namespace App\Http\Controllers;
use App\Models\AccidentReport;

class AccidentReportController extends Controller
{
    public function getAccidentReports()
    {
        $accidentReports = AccidentReport::all();

        return response()->json($accidentReports);
    }

    public function getLocations()
{
    $confirmedLocations = AccidentReport::where('location_status', true)->get(['latitude', 'longitude', 'location_status']);
    $pendingLocations = AccidentReport::where('location_status', false)->get(['latitude', 'longitude', 'location_status']);

    return response()->json([
        'confirmedLocations' => $confirmedLocations,
        'pendingLocations' => $pendingLocations,
    ], 200, [], JSON_NUMERIC_CHECK); // Ensure boolean values are cast to integers
}

public function updateLocation(Request $request)
{
    $reportId = $request->input('reportId');
    $newLatitude = $request->input('newLatitude');
    $newLongitude = $request->input('newLongitude');

    // Update the location in the database
    $report = AccidentReport::find($reportId);
    $report->latitude = $newLatitude;
    $report->longitude = $newLongitude;
    $report->save();

    return response()->json(['message' => 'Location updated successfully']);
}
}
