<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Company;
use App\Department;
use Carbon, Validator;

class DepartmentController extends Controller
{
    /**
    * For user access control
    */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Department::query();

        if(!isSuperAdmin()){
            $query->whereCompanyId($request->user()->company_id);
        }

        $departments = $query->whereParentId(0)->latest('id')->paginate(10);
        $departments->paginationSummery = getPaginationSummery($departments->total(), $departments->perPage(), $departments->currentPage());
        if(isSuperAdmin()) {
            $companies = Company::getDropDownList();
        }

        return view('departments.index', compact('departments', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'title'     => 'required',
            'branch_id' => 'required|integer|min:1',
        );

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store
            $department = !$request->has('department_id') ? new Department : Department::findOrFail($request->department_id);
            if(isSuperAdmin()) {
                $department->company_id = $request->company_id;
            }else {
                $department->company_id = $request->user()->company_id;
            }
            
            $department->branch_id = $request->branch_id;
            $department->parent_id = $request->has('parent_id') ? $request->parent_id : 0;
            $department->title = trim($request->title);
            $department->description = trim($request->description);
            if($request->has('priority')) {
                $department->priority = trim($request->priority);
            }
            
            if(!$request->has('department_id')) {
                $msg = 'added';
                $department->created_by = $request->user()->id;
            }else {
                $msg = 'updated';
                $department->updated_by = $request->user()->id;
            }

            if($department->save()) { 
                
                return response()->json(['status' => 200, 'type' => 'success', 'message' => 'Department has been successfully '.$msg]);
            }else{
                
                return response()->json(['status' => 404, 'type' => 'error', 'message' => 'Department has not been successfully '.$msg]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);
        $department->department_parent = $department->parent ? $department->parent->title : 'N/A';
        $department->company_title = $department->company ? $department->company->title : 'N/A';
        $department->branch_title = $department->branch ? $department->branch->title : 'N/A';
        $department->created_date = $department->created_at;

        return $department->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if(Department::destroy($request->hdnResource)){
            $message = toastMessage('Department has been successfully removed.','success');
        }else{
            $message = toastMessage('Department has not been removed.','error');
        }

        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }

    /**
    * Get employees based on company id
    *
    * @param int $id
    * @param int $department_id
    * @return \Illuminate\Http\Response
    */
    public function getBranches($id, $department_id=null)
    {
        $branches = Branch::whereCompanyId($id)->pluck('title', 'id')->all();

        $branch_options = '<option value="">Select a branch</option>';
        if($department_id) {
            $department = Department::find($department_id);
        }
        $selected = '';
        foreach($branches as $branch_id=>$title) {
            if(!empty($department) && $department->branch_id == $branch_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $branch_options .= '<option value="'.$branch_id.'"'.$selected.'>'.$title.'</option>';
        }

        return $branch_options;
    }

    /**
    * Get employees based on company id
    *
    * @param int $id
    * @param int $department_id
    * @return \Illuminate\Http\Response
    */
    public function getDepartments($id, $department_id=null)
    {
        $query = Department::whereBranchId($id)->pluck('title', 'id');

        if($department_id) {
            $department = Department::find($department_id);
            $query = $query->except($department_id);
        }
        $departments = $query->all();
        $department_options = '<option value="">Parent</option>';
        
        $selected = '';
        foreach($departments as $department_id=>$title) {
            if(!empty($department) && $department->parent_id == $department_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $department_options .= '<option value="'.$department_id.'"'.$selected.'>'.$title.'</option>';
        }
        
        return $department_options;
    }

    public function anyBulkDepartments(Request $request){
        
        $query = Department::query();
        
        if(!isSuperAdmin()){
            $query->whereCompanyId($request->user()->company_id);
        }

        $departments = $query->whereParentId(0)->latest('id')->paginate(10);
        $departments->paginationSummery = getPaginationSummery($departments->total(), $departments->perPage(), $departments->currentPage());
        if(isSuperAdmin()) {
            $companies = Company::getDropDownList();
        }

        return view('departments.bulk', compact('departments', 'companies'));
    }
    public function postBulksave(Request $request){
        
        $rules = array(
            'title'     => 'required',
            'branch_id' => 'required|integer|min:1',
        );

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store           
            if(isSuperAdmin()) {
                $company_id = $request->company_id;
            }else {
                $company_id = $request->user()->company_id;
            }

            $all_departments_title_raw = trim($request->title);
            $all_departments_title_array = explode(PHP_EOL, $all_departments_title_raw);
            
            $success_flag = 0;
            $failed_flag = 0;

            if(is_array($all_departments_title_array)){
                foreach ( $all_departments_title_array as $all_departments_title ){
                    $department = !$request->has('department_id') ? new Department : Department::findOrFail($request->department_id);
                    $department->company_id = $company_id;
                    $department->branch_id = $request->branch_id;
                    $department->parent_id = $request->has('parent_id') ? $request->parent_id : 0;
                    $department->title = trim($all_departments_title);
                    $department->description = trim($request->description);
                    if($request->has('priority')) {
                        $department->priority = trim($request->priority);
                    }
                    
                    if(!$request->has('department_id')) {
                        $msg = 'added';
                        $department->created_by = $request->user()->id;
                    }else {
                        $msg = 'updated';
                        $department->updated_by = $request->user()->id;
                    }
                    if( $department->title != '' ){
                        if($department->save()) {                         
                            //save success
                            $success_flag++;
                        }else{                        
                            $failed_flag++;
                        }
                    }
                    else{
                        $failed_flag++;
                    }                                        
                }
            }

            if($success_flag != 0) {                
                return response()->json(['status' => 200, 'type' => 'success', 'message' => $success_flag.' department(s) successfully '.$msg.' #Failed: '.$failed_flag]);
            }else{                
                return response()->json(['status' => 404, 'type' => 'error', 'message' => $failed_flag.' department(s) save failed']);
            }
        }
    }    
}
