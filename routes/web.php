<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController2;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\AccidentReportController;
use App\Http\Controllers\EditCredentialsController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
Route::get('/mark-notifications-as-read', 'NotificationController@markAsRead');
Route::get('/form', [UserController2::class, 'showForm'])->middleware('auth')->name('form');
Route::patch('/edit-credentials', [UserController2::class, 'editCredentials'])->middleware('auth')->name('editCredentials');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('/reports',  [ReportController::class, 'showReports'])->name('reports.ReportDashboard');
Route::post('/announcements', [AnnouncementController::class, 'store']);
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/settings', [UserSettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/profile', [UserSettingsController::class, 'updateProfile'])->name('settings.updateProfile');
Route::post('/settings/password', [UserSettingsController::class, 'updatePassword'])->name('settings.updatePassword');
Route::delete('/delete/{id}', [ReportController::class, 'deleteReport'])->name('report.deleteReport');
Route::get('/change-marker', [EditCredentialsController::class, 'showChooseMarkerForm'])->name('chooseMarkerForm');
Route::post('/update-chosen-marker', [UserController2::class, 'saveCustomMarker'])->name('updateChosenMarker'); 


    // ... other routes ...
});

    Route::group(['middleware' => 'admin'], function () {
    // Routes that require admin access
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::get('/admin/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/report/{report}', [DashboardController::class, 'showReport'])->name('dashboard.report');
    Route::get('/admin/accident_reports', [AdminController::class, 'showReports'])->name('admin.accident_reports');
    Route::post('/admin/accident_reports/confirm/{id}', [AdminController::class, 'confirmReport'])->name('admin.confirmReport');
    Route::delete('/admin/accident_reports/delete/{id}', [AdminController::class, 'deleteReport'])->name('admin.deleteReport');
    Route::put('/admin/accident_reports/revert/{id}', [AdminController::class, 'revertReportStatus'])->name('admin.revertReportStatus');

    // Add more routes as needed
});

Route::group(['middleware' => 'restricted'], function () {
Route::get('/RestrictedAcc',[UserController2::class, 'showRestrictedDashboard'])->name('restricted.dashboard');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        // Redirect admin user to the admin dashboard
        return redirect()->route('admin.dashboard');
    } elseif ($user->isRestricted()) {
        // Redirect restricted user to the restricted dashboard
        return redirect()->route('restricted.dashboard');
    } else {
        // Regular user dashboard logic
        return view('testmap', ['user' => $user]);
    }
})->middleware('auth')->name('dashboard');



Route::get('/register', [UserController2::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController2::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [UserController2::class, 'logout'])->name('logout');
Route::get('/logout', [UserController2::class, 'logout'])->name('logout');


Route::post('/submit-report', [ReportController::class, 'submitReport'])->name('submit-report');


Route::get('/accident-reports', [AccidentReportController::class, 'getAccidentReports']);


Route::get('/get-chosen-marker', [UserController2::class, 'getChosenMarker']);

Route::get('/get-locations', [AccidentReportController::class, 'getLocations']);



Route::get('/change-marker', [EditCredentialsController::class, 'showChooseMarkerForm'])->name('chooseMarkerForm');
Route::post('/update-chosen-marker', [UserController2::class, 'saveCustomMarker'])->name('updateChosenMarker');


Route::get('/dashboard/report/{report}', [DashboardController::class, 'showReport'])->name('dashboard.report');

 Route::post('/admin/accident_reports/confirm/{id}', [AdminController::class, 'confirmReport'])->name('admin.confirmReport');

Route::get('/admin/manage-roles', [AdminController::class,'manageRoles'])->name('admin.manageRoles');
Route::post('/admin/update-role', [AdminController::class,'updateRole'])->name('admin.updateRole');

Route::get('/admin/search-user', [AdminController::class,'searchUsers'])->name('admin.searchUsers');

Route::get('/editcredentials', function () {
    return view('EditCredentials.UserSettings');
});


Route::post('/update-location', [AccidentReportController::class,'updateLocation'])->name('update-location');
Route::get('/update-location', [AccidentReportController::class,'updateLocation']);

Route::get('/admin/show_reports', [AdminController::class, 'showReport'])->name('admin.show_reports');

