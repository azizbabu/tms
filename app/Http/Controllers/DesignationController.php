<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Company;
use App\Designation;
use Carbon, Validator;

class DesignationController extends Controller
{
    /**
    * For user access control
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Designation::query();

        if(!isSuperAdmin()){
            $query->whereCompanyId($request->user()->company_id);
            if(isDepartmentAdmin()) {
                $query->whereBranchId($request->user()->branch_id);
            }
        }

        $designations = $query->whereParentId(0)->latest('id')->paginate(10);
        $designations->paginationSummery = getPaginationSummery($designations->total(), $designations->perPage(), $designations->currentPage());
        if(isSuperAdmin()) {
            $companies = Company::getDropDownList();
        }

        return view('designations.index', compact('designations', 'companies'));
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
            'title'  => 'required',
        );

        if(isSuperAdmin()) {
            $rules = $rules + [
                'company_id' => 'required|integer|min:1',
            ];
        }

        if(isSuperAdminOrAdmin()) {
            $rules = $rules + [
                'branch_id' => 'required|integer|min:1',
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store
            // dd($request->all());
            $designation = !$request->has('designation_id') ? new Designation : Designation::findOrFail($request->designation_id);
            $designation->parent_id = $request->has('parent_id') ? $request->parent_id : 0;
            if(isSuperAdmin()) {
                $designation->company_id = $request->company_id;
            }else {
                $designation->company_id = $request->user()->company_id;
            }
            if(isSuperAdminOrAdmin()) {
                $designation->branch_id = $request->branch_id;
            }else {
                $designation->branch_id = $request->user()->branch_id;
            }
            $designation->title = trim($request->title);
            $designation->description = trim($request->description);
            
            if(!$request->has('designation_id')) {
                $msg = 'added';
                $designation->created_by = $request->user()->id;
            }else {
                $msg = 'updated';
                $designation->updated_by = $request->user()->id;
            }
            if($designation->save()) { 
                
                return response()->json(['status' => 200, 'type' => 'success', 'message' => 'Designation has been successfully '.$msg]);
            }else{
                
                return response()->json(['status' => 404, 'type' => 'error', 'message' => 'Designation has not been successfully '.$msg]);
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
        $designation = Designation::findOrFail($id);
        $designation->designation_parent = $designation->parent ? $designation->parent->title : 'N/A';
        $designation->company_title = $designation->company ? $designation->company->title : 'N/A';
        $designation->branch_title = $designation->branch ? $designation->branch->title : 'N/A';
        $designation->created_date = $designation->created_at;

        return $designation->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $designations = Designation::whereIn('id', [$request->hdnResource])->get();
        $designation_ids = Designation::getDesignationIds($designations);

        if(Designation::destroy($designation_ids)){
            $message = toastMessage('Designation has been successfully removed.','success');
        }else{
            $message = toastMessage('Designation has not been removed.','error');
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
    public function getBranches($id, $designation_id=null)
    {
        $branches = Branch::whereCompanyId($id)->pluck('title', 'id')->all();

        $branch_options = '<option value="">Select a branch</option>';
        if($designation_id) {
            $designation = Designation::find($designation_id);
        }
        $selected = '';
        foreach($branches as $branch_id=>$title) {
            if(!empty($designation) && $designation->branch_id == $branch_id) {
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
    * @param int $designation_id
    * @return \Illuminate\Http\Response
    */
    public function getDesignations($id, $designation_id=null)
    {
        $query = Designation::whereBranchId($id)->pluck('title', 'id');

        if($designation_id) {
            $designation = Designation::find($designation_id);
            $query = $query->except($designation_id);
        }
        $designations = $query->all();
        $designation_options = '<option value="">Parent</option>';
        
        $selected = '';
        foreach($designations as $designation_id=>$title) {
            if(!empty($designation) && $designation->parent_id == $designation_id) {
                $selected = ' selected="selected"';
            }else {
                $selected = '';
            }
            $designation_options .= '<option value="'.$designation_id.'"'.$selected.'>'.$title.'</option>';
        }
       
        return $designation_options;
    }
}
