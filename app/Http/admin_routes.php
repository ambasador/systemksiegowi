<?php
/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Dashboard ================== */
	
	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');
	
	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	
	
	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');
	
	
	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');
	

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

	/* ================== Limiteds ================== */
	Route::resource(config('laraadmin.adminRoute') . '/limiteds', 'LA\LimitedsController');
	Route::get(config('laraadmin.adminRoute') . '/limited_dt_ajax', 'LA\LimitedsController@dtajax');

	/* ================== Self-employments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/self-employments', 'LA\Self-employmentsController');
	Route::get(config('laraadmin.adminRoute') . '/self-employment_dt_ajax', 'LA\Self-employmentsController@dtajax');

	/* ================== Self_Employments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/self_employments', 'LA\Self_EmploymentsController');
	Route::get(config('laraadmin.adminRoute') . '/self_employment_dt_ajax', 'LA\Self_EmploymentsController@dtajax');

	/* ================== Partnerships ================== */
	Route::resource(config('laraadmin.adminRoute') . '/partnerships', 'LA\PartnershipsController');
	Route::get(config('laraadmin.adminRoute') . '/partnership_dt_ajax', 'LA\PartnershipsController@dtajax');


	/* ================== Partnership_LPs ================== */
	Route::resource(config('laraadmin.adminRoute') . '/partnership_lps', 'LA\Partnership_LPsController');
	Route::get(config('laraadmin.adminRoute') . '/partnership_lp_dt_ajax', 'LA\Partnership_LPsController@dtajax');
});
