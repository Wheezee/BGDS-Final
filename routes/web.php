<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\FinancialRecordController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FinancialRecord;
use App\Models\Meeting;

// Route for the login page
Route::get('/', [UserController::class, 'index'])->name('login');

// Route for user login
Route::post('/login', [UserController::class, 'login'])->name('login.submit');

// Route for user logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Route for user registration
Route::post('/register', [UserController::class, 'register'])->name('register');


// Dashboard route - accessible to all authenticated users
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::post('/resident_store', [ResidentController::class, 'store']);

Route::get('/add_resident', function () {
    return view('add_resident');
});

Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');

// Resident routes - accessible to all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');
    Route::get('/residents/create', [ResidentController::class, 'create'])->name('residents.create');
    Route::post('/residents', [ResidentController::class, 'store'])->name('residents.store');
    Route::get('/residents/{resident}', [ResidentController::class, 'show'])->name('residents.show');
    Route::get('/residents/{resident}/edit', [ResidentController::class, 'edit'])->name('residents.edit');
    Route::put('/residents/{resident}', [ResidentController::class, 'update'])->name('residents.update');
    Route::delete('/residents/{resident}', [ResidentController::class, 'destroy'])->name('residents.destroy');
    Route::get('/residents-all-info', [ResidentController::class, 'allResidentsInfo'])->name('residents.all-residents-info');
    Route::post('/residents/import', [ResidentController::class, 'import'])->name('residents.import');
    
    // User profile routes - accessible to all authenticated users
    Route::get('/userProfile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/userProfile', [UserController::class, 'update'])->name('user.update');

    // User management routes - only for superadmin and admin
    Route::middleware(['auth'])->group(function () {
        Route::get('/users', function () {
            if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin'])) {
                abort(403, 'Unauthorized Access');
            }
            return app(UserController::class)->userList();
        })->name('users.index');

        Route::get('/users/create', function () {
            if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin'])) {
                abort(403, 'Unauthorized Access');
            }
            return app(UserController::class)->create();
        })->name('users.create');

        Route::post('/users', function (Request $request) {
            if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin'])) {
                abort(403, 'Unauthorized Access');
            }
            return app(UserController::class)->store($request);
        })->name('users.store');

        Route::get('/users/{user}', function (User $user) {
            if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin'])) {
                abort(403, 'Unauthorized Access');
            }
            return app(UserController::class)->show($user);
        })->name('users.show');

        Route::get('/users/{user}/edit', function (User $user) {
            if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin'])) {
                abort(403, 'Unauthorized Access');
            }
            return app(UserController::class)->edit($user);
        })->name('users.edit');

        Route::put('/users/{user}', function (Request $request, User $user) {
            if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin'])) {
                abort(403, 'Unauthorized Access');
            }
            return app(UserController::class)->updateUser($request, $user);
        })->name('users.update');

        Route::delete('/users/{user}', function (User $user) {
            if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin'])) {
                abort(403, 'Unauthorized Access');
            }
            return app(UserController::class)->destroy($user);
        })->name('users.destroy');
    });
});

// Financial records routes
Route::get('/finance', function (Request $request) {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(FinancialRecordController::class)->index($request);
})->name('finance.index')->middleware('auth');

Route::get('/finance/create', function () {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(FinancialRecordController::class)->create();
})->name('finance.create')->middleware('auth');

Route::post('/finance', function (Request $request) {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(FinancialRecordController::class)->store($request);
})->name('finance.store')->middleware('auth');

Route::get('/finance/{finance}', [FinancialRecordController::class, 'show'])
    ->name('finance.show')
    ->middleware('auth')
    ->middleware('can:view,finance');

Route::get('/finance/{finance}/edit', [FinancialRecordController::class, 'edit'])
    ->name('finance.edit')
    ->middleware('auth')
    ->middleware('can:update,finance');

Route::put('/finance/{finance}', function (Request $request, FinancialRecord $finance) {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(FinancialRecordController::class)->update($request, $finance);
})->name('finance.update')->middleware('auth');

Route::delete('/finance/{finance}', function (FinancialRecord $finance) {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(FinancialRecordController::class)->destroy($finance);
})->name('finance.destroy')->middleware('auth');

// Meetings routes
Route::get('/meetings', function () {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(MeetingController::class)->index();
})->name('meetings.index')->middleware('auth');

Route::get('/meetings/create', function () {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(MeetingController::class)->create();
})->name('meetings.create')->middleware('auth');

Route::post('/meetings', function () {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(MeetingController::class)->store(request());
})->name('meetings.store')->middleware('auth');

Route::get('/meetings/{meeting}', [MeetingController::class, 'show'])
    ->name('meetings.show')
    ->middleware('auth')
    ->middleware('can:view,meeting');

Route::get('/meetings/{meeting}/edit', [MeetingController::class, 'edit'])
    ->name('meetings.edit')
    ->middleware('auth')
    ->middleware('can:update,meeting');

Route::put('/meetings/{meeting}', [MeetingController::class, 'update'])
    ->name('meetings.update')
    ->middleware('auth')
    ->middleware('can:update,meeting');

Route::delete('/meetings/{meeting}', function (Meeting $meeting) {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(MeetingController::class)->destroy($meeting);
})->name('meetings.destroy')->middleware('auth');

// Meeting Attachments routes
Route::get('/meeting-attachments/{attachment}/download', [MeetingController::class, 'downloadAttachment'])
    ->name('meeting-attachments.download')
    ->middleware('auth');

Route::delete('/meeting-attachments/{attachment}', function (App\Models\MeetingAttachment $attachment) {
    if (auth()->user()->role !== 'superadmin' && !in_array(auth()->user()->role, ['admin', 'barangay_chairman', 'barangay_secretary'])) {
        abort(403, 'Unauthorized Access');
    }
    return app(MeetingController::class)->deleteAttachment($attachment);
})->name('meeting-attachments.destroy')->middleware('auth');

// Meeting Transcription download route
Route::get('/meetings/{meeting}/download-transcription', [MeetingController::class, 'downloadTranscription'])
    ->name('meetings.download-transcription')
    ->middleware('auth');

// Meeting PDF export route
Route::get('/meetings/{meeting}/export-pdf', [MeetingController::class, 'exportPdf'])
    ->name('meetings.export-pdf')
    ->middleware('auth')
    ->middleware('can:view,meeting');

// Projects routes
Route::middleware(['auth'])->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])
        ->name('projects.index')
        ->middleware('can:viewAny,App\Models\Project');

    Route::get('/projects/create', [ProjectController::class, 'create'])
        ->name('projects.create')
        ->middleware('can:create,App\Models\Project');

    Route::post('/projects', [ProjectController::class, 'store'])
        ->name('projects.store')
        ->middleware('can:create,App\Models\Project');

    Route::get('/projects/{project}', [ProjectController::class, 'show'])
        ->name('projects.show')
        ->middleware('can:view,project');

    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])
        ->name('projects.edit')
        ->middleware('can:update,project');

    Route::put('/projects/{project}', [ProjectController::class, 'update'])
        ->name('projects.update')
        ->middleware('can:update,project');

    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
        ->name('projects.destroy')
        ->middleware('can:delete,project');
});

