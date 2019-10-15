<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', 'User\HomeController@index')->name('home');

/*
|--------------------------------------------------------------------------
| Custom Admin login register route by Animesh
|--------------------------------------------------------------------------
*/

Route::GET('admin/home', 'Admin\AdminController@index')->name('admin.home');
Route::GET('admin', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::POST('admin', 'Admin\Auth\LoginController@login');

Route::POST('admin-password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::GET('admin-password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::POST('admin-password/reset','Admin\Auth\ResetPasswordController@reset')->name('admin.password.update');
Route::GET('admin-password/reset/{token}','Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

Route::GET('admin/register','Admin\Auth\RegisterController@showRegistrationForm')->name('admin.register');
Route::POST('admin/register','Admin\Auth\RegisterController@register');

Route::get('admin/email/verify', 'Admin\Auth\VerificationController@show')->name('admin.verification.notice');
Route::get('admin/email/verify/{id}', 'Admin\Auth\VerificationController@verify')->name('admin.verification.verify');
Route::get('admin/email/resend', 'Admin\Auth\VerificationController@resend')->name('admin.verification.resend');
/*
|--------------------------------------------------------------------------
| End Custom login register route
|--------------------------------------------------------------------------
*/

/*
|----------------------------------------------------------------------
| Audit Schedule
|-----------------------------------------------------------------------
*/ 
Route::middleware(['auth:admin', 'admin.verified'])->group(function () {
	Route::namespace('Admin')->group(function () {
	    // Controllers Within The "App\Http\Controllers\Admin" Namespace
	    Route::resource('roles', 'RoleController');
	    Route::namespace('Audit')->group(function () {
	    	Route::resource('audits', 'AuditScheduleController');
	    });
	});
    
});

/*
|----------------------------------------------------------------------
| End Audit Schedule
|-----------------------------------------------------------------------
*/ 