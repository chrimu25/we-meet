<?php

use App\Models\Meeting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\MeetingsController;
use App\Http\Controllers\AttendMeetingController;
use Illuminate\Support\Facades\Artisan;

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
    $meetings = Meeting::latest('meeting_date')->upcoming()->limit(4)->get();
    return view('welcome', compact('meetings'));
});
Route::post('enquiry',EnquiryController::class)->name('contact.save');

Route::get('meetings', function(){
    $meetings = Meeting::latest()->simplePaginate(12);
    return view('meetings', compact('meetings'));
})->name('meetings');
Route::get('meetings/{meeting}', [MeetingsController::class,'show'])->name('meetings.details')->middleware('auth');
Route::get('register-attendance/{meeting}/{youth}', AttendMeetingController::class)->name('meetings.attend')->middleware('auth');

Route::view('dashboard','dashboard')->name('dashboard');

Route::view('account','account')->name('account');

Route::get('web-artisan', function(){
    Artisan::call('migrate');
    return 'something';
});
