<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\AccidentReport;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function showReport($reportId)
    {
        // Fetch the report details from the database based on the report ID
        $report = AccidentReport::findOrFail($reportId);

        // Pass the report details to the view
        return view('dashboard.show_report', ['report' => $report]);
    }
}
