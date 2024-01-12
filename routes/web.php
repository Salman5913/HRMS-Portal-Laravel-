<?php

use App\Events\TicketChat;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

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



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/**************** ADMIN ROUTES ******************/
Route::get('/admin', function () {
    return view('admin.login');
})->name('admin-login-page');

Route::post('/admin-login',[AdminController::class,'login'])->name('admin-login');
Route::any('/admin-dashboard',[AdminController::class, 'index'])->name('admin-dashboard')->middleware('isAdmin');
Route::get('/user-list',[AdminController::class , 'ShowUserList'])->name('user-list');
Route::get('/admin-logout',[AdminController::class,'logout'])->name('admin-logout');
Route::get('/add-user-form',[AdminController::class , 'ShowAddUserForm'])->name('add-user-form');
Route::post('/add-user',[AdminController::class , 'AddUser'])->name('add-user');
Route::get('/edit-form/{id}',[AdminController::class , 'ShowEditForm'])->name('edit-form');
Route::post('/update-user/{id}',[AdminController::class , 'UpdateUserData'])->name('update-user');
Route::get('/delete-user/{id}',[AdminController::class , 'DeleteUser'])->name('delete-user');
Route::get('/manage-leave',[AdminController::class , 'ShowEmployeeLeaveList'])->name('manage-leave');
Route::post('/save-leave-status',[AdminController::class , 'SaveLeaveStatus'])->name('save-leave-status');
Route::get('/manage-ticket' , [AdminController::class , 'ShowTicketList'])->name('manage-ticket');
Route::get('/ticket/{ticket_id}',[AdminController::class , 'ShowTicketDetails'])->name('admin-ticket-details');
Route::post('/ticket-reply',[AdminController::class ,'SendTicketMessage'])->name('ticket-reply');

/**************** EMPLOYEE ROUTES ******************/
Route::get('/', function () {
    return view('employee.login');
})->name('employee-login-page');

Route::post('/employee-login',[EmployeeController::class , 'login'])->name('employee-login');
Route::any('/employee-dashboard',[EmployeeController::class , 'index'])->name('employee-dashboard')->middleware('isEmployee');
Route::get('/employee-logout',[EmployeeController::class , 'logout'])->name('employee-logout');
Route::get('/leave',[EmployeeController::class , 'ShowLeaveList'])->name('leave-list');
Route::get('/apply-leave',[EmployeeController::class , 'ShowAddLeaveForm'])->name('apply-leave');
Route::post('/add-leave',[EmployeeController::class , 'AddLeave'])->name('add-leave');
Route::get('/attendance',[EmployeeController::class, 'ShowAttendanceList'])->name('attendance-list');
Route::get('/mark-attendance',[EmployeeController::class, 'ShowAttendanceMarkPage'])->name('mark-attendance');
Route::post('/add-attendance',[EmployeeController::class, 'AddAttendance'])->name('add-attendance');
Route::get('/ticket-list',[EmployeeController::class, 'ShowTicketList'])->name('ticket-list');
Route::post('/add-ticket',[EmployeeController::class,'AddTicket'])->name('add-ticket');
Route::get('/ticket-details/{ticket_id}',[EmployeeController::class , 'ShowTicketDetails'])->name('ticket-details');
Route::post('/send-ticket-message',[EmployeeController::class, 'SendTicketMessage'])->name('send-ticket-message');

require __DIR__ . '/auth.php';
