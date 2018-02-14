<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Department;
use App\Employee;
use App\Permission;
use App\User;
use Validator;

class PermissionController extends Controller
{
    /**
     * Set user access control
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a form to set permission for an employee
     *
     * @param \Illuminate\Http\Request $request;
     * @param int $user_id;
     * @return \Illuminate\Http\Response;
     */
    public function index(Request $request, $user_id)
    {
    	$user = User::find($user_id);

    	if(!$user) {

    		session()->flash('toast', toastMessage('User not found!'));

    		return redirect('home');
    	}

        $permission_exists = Permission::whereUserId($user->id)->first();

    	if($request->isMethod('POST')) {

    		// insert or update permission
            
            $permission = $permission_exists ? $permission_exists : new Permission;
            $permission->user_id = $user->id;
            
            if($request->has('branch_id')) {
                $permission->branch_ids = implode(',', array_map('trim', $request->branch_id));
            }else {
                $permission->branch_ids = null;
            }

            if($request->has('department_id')) {
                $department_ids = array_map('trim', $request->department_id);
                $departments = Department::whereIn('id', $department_ids)->get();
                $department_ids = Department::getDepartmentIds($departments);
                $permission->department_ids = implode(',', array_map('trim', $department_ids));
            }else {
                $permission->department_ids = null;
            }

            $msg = $permission_exists ? 'updated.' : 'added.';

            if($permission->save()) {
                $message = toastMessage('Permission info  has been successfully '. $msg);
            }else {
                $message = toastMessage('Permission info has not been '. $msg);
            }

            session()->flash('toast', $message);

            return back();
    	}

    	$employee = $user->employee;
        $permission = $permission_exists;

        if(!$permission) {
            $permission = new Permission;
            $department_ids = [];
        }else {
            $department_ids = explode(',', $permission->department_ids);
        }
        
    	$branches = Branch::whereCompanyId($employee->company_id)->pluck('title', 'id');
    	$departments = Department::whereCompanyId($employee->company_id)->whereParentId(0)->get();
    	$department_list = Department::getDepartmentCheckboxList($departments, 'list-unstyled', $department_ids);

    	return view('permission', compact('user', 'employee', 'branches', 'department_list', 'permission'));
    }
}
