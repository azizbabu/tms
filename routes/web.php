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

Auth::routes();

Route::any('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', function() {
	return redirect('login');
});

/*Owner Dashboard*/
Route::any('owner-dashboard', 'OwnerDashboardController@index');

/*Department Owner Dashboard */
Route::any('department-owner-dashboard', 'DepartmentOwnerDashboard@index');

Route::any('/home', 'HomeController@index')->name('home');

// Employer Routes...
Route::get('task-management', 'EmployeeController@getTaskManagement');
Route::post('employees/delete', 'EmployeeController@delete');
Route::get('employees/branches/{company_id}/{employee_id?}', 'EmployeeController@getBranches');
Route::get('employees/departments/{branch_id}/{employee_id?}', 'EmployeeController@getDepartments');
Route::any('employees/list', 'EmployeeController@employeeList');
Route::resource('employees', 'EmployeeController');

// User Routes...
Route::post('users/change-active', 'UserController@changeActive');
Route::any('users/profile', 'UserController@profile');
Route::get('users/account-varification/{secret_code}', 'UserController@getAccountVarification');
Route::get('users/reset-password/{username}', 'UserController@getResetPassword');

// Companies Routes...
Route::any('my-company', 'CompanyController@myCompany');
Route::post('companies/delete', 'CompanyController@delete');
Route::resource('companies', 'CompanyController');

// Branch Routes...
Route::post('branches/delete', 'BranchController@delete');
Route::resource('branches', 'BranchController');

// Departments Routes...
Route::get('departments/branches/{company_id}/{department_id?}', 'DepartmentController@getBranches');
Route::get('departments/departments/{branch_id}/{department_id?}', 'DepartmentController@getDepartments');
Route::post('departments/delete', 'DepartmentController@delete');
Route::resource('departments', 'DepartmentController');
Route::any('bulk-departments', 'DepartmentController@anyBulkDepartments');
Route::post('departments/bulksave', 'DepartmentController@postBulksave');

// Designation Routes...
Route::get('designations/branches/{company_id}/{designation_id?}', 'DesignationController@getBranches');
Route::get('designations/parent-designations/{branch_id}/{designation_id?}', 'DesignationController@getDesignations');
Route::post('designations/delete', 'DesignationController@delete');
Route::resource('designations', 'DesignationController');

// Task Role Routes...
Route::get('task-roles/branches/{company_id}/{task_role_id?}', 'TaskRoleController@getBranches');
Route::get('task-roles/departments/{branch_id}/{task_role_id?}', 'TaskRoleController@getDepartments');
Route::post('task-roles/delete', 'TaskRoleController@delete');
Route::resource('task-roles', 'TaskRoleController');

// Task Routes...
Route::get('tasks/branches/{company_id}/{task_id?}', 'TaskController@getBranches');
Route::get('tasks/departments/{branch_id}/{task_id?}', 'TaskController@getDepartments');
Route::get('tasks/parent-tasks/{department_id}/{task_id?}', 'TaskController@getTasks');
Route::any('tasks/create', 'TaskController@create');
Route::post('tasks/delete', 'TaskController@delete');
Route::any('tasks/{id}', 'TaskController@show')->where('id','[0-9]+');
Route::any('tasks/{slug}', 'TaskController@taskDetails');
Route::resource('tasks', 'TaskController',['except' => ['create','show']]);

//bulk task route
Route::get('tasks-bulk-create', 'TaskController@getBulkTaskCreate');
Route::post('tasks-bulk-save', 'TaskController@bulkTaskSave');
//bulk task route end

// Todo Routes...
Route::get('todo/assign-tasks', 'TodoListController@getNextAsignedTasks');
Route::get('todo/assign-dummy-tasks/{username}', 'DummyDataGenerateController@createDummyTasks');
Route::post('todo/delete', 'TodoListController@delete');
Route::post('todo/change-status/{id}', 'TodoListController@changeStatus');
Route::post('todo/save-achievement-log', 'TodoListController@saveAchievementLog');
Route::any('todo/{id}', 'TodoListController@show');

// Employee task routes...
Route::get('employee-tasks/employee/{employee_id}', 'EmployeeTaskController@showEmployeeTasks');
Route::post('employee-tasks/assign-predefined-task', 'EmployeeTaskController@assignPredefinedTask');
Route::post('employee-tasks/assign-need-basis-task', 'EmployeeTaskController@assignNeedBasisTask');
Route::post('employee-tasks/delete', 'EmployeeTaskController@delete');
Route::resource('employee-tasks', 'EmployeeTaskController');

/**
 * Auth Route Group...
 */
Route::group(['middleware' => 'auth'], function() {
    Route::get('notifications' ,'NotificationController');
    
    // Report Routes...
    Route::any('reports/todo/{action?}', 'ReportController@todoReport');
    Route::any('reports/target-achievement/{action?}', 'ReportController@getTargetAchievementReport');
    Route::get('settings', 'OptionController@index');
    Route::post('settings/save', 'OptionController@save');

    // Frequency Routes...
    Route::post('frequencies/change-status', 'FrequencyController@changeStatus');
    Route::post('frequencies/delete', 'FrequencyController@delete');
    Route::resource('frequencies', 'FrequencyController');

    Route::any('employee-task-allocation/{employee_id?}', 'EmployeeTaskAllocationController@index');

    Route::get('/task-manager', 'TaskManagerController@index')->name('task-manager');

    Route::any('permission/{user_id}', 'PermissionController@index');

    Route::get('employee-dashboard/{employee_id}', 'EmployeeDashboardController@index');

    Route::get('branch-dashboard/{id}', 'BranchDashboardController@index');

    Route::get('department-dashboard/{id}', 'DepartmentDashboardController@index');
});

Route::get('test', function() {
    $employees = \App\Employee::whereIn('id', [12])->get();
    $employee_ids = array_diff(\App\Employee::getEmployeeIds($employees), [\Auth::id()]);
    dd($employee_ids);
    dd(\App\Designation::find(25)->employees);
    $department = \App\Department::find(20);
    dd(\App\Department::getParentDepartmentIds($department));
});