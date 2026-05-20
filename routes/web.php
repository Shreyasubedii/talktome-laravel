<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\ScheduleController as DoctorScheduleController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Doctor\PatientController as DoctorPatientController;
use App\Http\Controllers\Doctor\SettingsController as DoctorSettingsController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\DoctorsController;
use App\Http\Controllers\Patient\BookingController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\RecommendationController;
use App\Http\Controllers\Patient\ScheduleController as PatientScheduleController;
use App\Http\Controllers\Patient\PaymentController;
use App\Http\Controllers\Patient\SettingsController as PatientSettingsController;
use App\Http\Controllers\Patient\DayLogController as DayLogController;

// Public routes
Route::get('/', function () {
    return redirect()->route('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['multi.auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/doctors', [AdminDoctorController::class, 'index'])->name('doctors');
    Route::post('/doctors', [AdminDoctorController::class, 'store'])->name('doctors.store');
    Route::delete('/doctors/{id}', [AdminDoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::get('/patients', [AdminPatientController::class, 'index'])->name('patients');
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments');
    Route::delete('/appointments/{id}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/schedules', [AdminScheduleController::class, 'index'])->name('schedules');
    Route::post('/schedules', [AdminScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('/schedules/{id}', [AdminScheduleController::class, 'destroy'])->name('schedules.destroy');
});

// Doctor routes
Route::prefix('doctor')->name('doctor.')->middleware(['multi.auth'])->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/schedules', [DoctorScheduleController::class, 'index'])->name('schedules');
    Route::post('/schedules', [DoctorScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('/schedules/{id}', [DoctorScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments');
    Route::delete('/appointments/{id}', [DoctorAppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/patients', [DoctorPatientController::class, 'index'])->name('patients');
    Route::get('/settings', [DoctorSettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [DoctorSettingsController::class, 'update'])->name('settings.update');
});

// Patient routes
Route::prefix('patient')->name('patient.')->middleware(['multi.auth'])->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/doctors', [DoctorsController::class, 'index'])->name('doctors');
    Route::get('/schedules', [PatientScheduleController::class, 'index'])->name('schedules');
    // Route::get('/schedules', [PatientScheduleController::class, 'index'])->name('patient.recommendation');

    // Route::get('/individualsessions', [PatientScheduleController::class, 'individualSessions'])
    // ->name('individual.sessions');
    // Route::get('/individualsessions', [IndividualSessionController::class, 'index'])
    // ->name('individual.sessions');
    Route::get('/booking/{doctorId}', [BookingController::class, 'index'])->name('booking');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/complete/{id}', [BookingController::class, 'complete'])->name('booking.complete');
    Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('appointments');
    Route::delete('/appointments/{id}', [PatientAppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/recommendation', [RecommendationController::class, 'index'])->name('recommendation');
    Route::post('/recommendation', [RecommendationController::class, 'index']);
    Route::get('/esewa', [PaymentController::class, 'esewa'])->name('esewa');
    Route::get('/esewa/success', [PaymentController::class, 'esewaSuccess'])->name('esewa.success');
    Route::get('/esewa/failure', [PaymentController::class, 'esewaFailure'])->name('esewa.failure');
    Route::get('/settings', [PatientSettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [PatientSettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings', [PatientSettingsController::class, 'destroy'])->name('settings.destroy');
    Route::get('/daylog', [DayLogController::class, 'index'])
    ->name('daylog');
    Route::get('/patient/recommendation', function () {
    return view('patient.recommendation');
})->name('patient.recommendation');

Route::post('/daylog', [DayLogController::class, 'store'])
    ->name('daylog.store');
});