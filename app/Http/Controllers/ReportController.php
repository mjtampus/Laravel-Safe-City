<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AccidentReport;
use Illuminate\Support\Facades\File;
use App\Notifications\ReportSubmitted;

class ReportController extends Controller
{
    public function submitReport(Request $request)
    {
        // Validate the form data, including the image (make image_url optional)
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Make it optional
        ]);
    
        if ($request->hasFile('image_url')) {
            // Get the public path to the images directory
            $publicPath = public_path('images');

            // If the images directory doesn't exist, create it
            if (!File::isDirectory($publicPath)) {
                File::makeDirectory($publicPath, 0755, true, true);
            }

            // Handle image upload and store in public/images folder
            $imagePath = $request->file('image_url')->move($publicPath, uniqid() . '.' . $request->file('image_url')->getClientOriginalExtension());

            // Set the relative path stored in the database
            $imagePath = 'images/' . pathinfo($imagePath->getFilename(), PATHINFO_BASENAME);
        } else {
            $imagePath = null; // Set image path to null if no image is provided
        }
        // Create a new AccidentReport instance with image path
        $report = new AccidentReport([
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'description' => $request->input('description'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'image_url' => $imagePath,
        ]);
    
        // Associate the report with the authenticated user
        auth()->user()->accidentReports()->save($report);
         // Trigger the notification for the authenticated user
         auth()->user()->notify(new ReportSubmitted(['report_id' => $report->id]));
        // Optionally, you can redirect the user to a success page or back to the form
        return redirect()->route('dashboard')->with('success', 'Report submitted successfully wait for admin to confirm');
    }

    public function showReports()
    {
        // Get confirmed reports for the authenticated user
        $confirmedReports = auth()->user()->accidentReports()->where('location_status', true)->get();

        // Get pending reports for the authenticated user
        $pendingReports = auth()->user()->accidentReports()->where('location_status', false)->get();

        return view('reports.ReportDashboard', compact('confirmedReports', 'pendingReports'));
    }
    public function deleteReport($id)
    {
        $report = AccidentReport::findOrFail($id);
        $report->delete();

        return redirect()->route('dashboard')->with('success', 'The accident report was canceled successfully.');
    }
}