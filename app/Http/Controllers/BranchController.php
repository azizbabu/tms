<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Branch;
use App\Company;
use App\Country;
use App\User;
use Carbon, File, Validator;

class BranchController extends Controller
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
        $query = Branch::query();

        if(!isSuperAdmin()){
            $query->whereCompanyId($request->user()->company_id);
        }

        $branches = $query->latest('id')->paginate(10);
        $branches->paginationSummery = getPaginationSummery($branches->total(), $branches->perPage(), $branches->currentPage());

        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(isSuperAdmin()) {
            $companies = Company::getDropDownList();
        }
        $countries = Country::pluck('name', 'country_code')->prepend('Select a Country', '')->all();
        
        return view('branches.create', compact('countries', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];
        if(isSuperAdmin()) {
            $rules['company_id'] = 'required|integer';
        }
        $rules = $rules + array(
            'title'         => 'required',
            'description'   => 'required',
            'country'     => 'required|max:10',
            'state'     => 'required|max:50',
            'city'     => 'required|max:50',
            'zip'     => 'required|max:50',
            'address'     => 'required',
        );

        if($request->has('established_year')) {
            $rules = $rules + array(
                'established_year'  => 'date|date_format:Y-m-d',
            );
        }

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            // store
            $branch = !$request->has('branch_id') ? new Branch : Branch::findOrFail($request->branch_id);
            if(isSuperAdmin()) {
                $branch->company_id = trim($request->company_id);
            }else {
                $branch->company_id = $request->user()->company_id;
            }
            $branch->title = trim($request->title);
            $branch->description = trim($request->description);
            $branch->contact_person_name = trim($request->contact_person_name);
            $branch->contact_person_phone = trim($request->contact_person_phone);
            $branch->contact_person_email = trim($request->contact_person_email);
            $branch->established_year = $request->has('established_year') ? trim($request->established_year) : null;
            $branch->address = trim($request->address);
            $branch->city = trim($request->city);
            $branch->state = trim($request->state);
            $branch->zip = trim($request->zip);
            $branch->country = trim($request->country);
            
            if(!$request->has('branch_id')) {
                $msg = 'added';
                $branch->created_by = $request->user()->id;
            }else {
                $msg = 'updated';
                $branch->updated_by = $request->user()->id;
            }
            if($branch->save()) { 
                $message = toastMessage ( " Branch information has been successfully $msg", 'success' );

            }else{
                $message = toastMessage ( " Branch information has not been successfully $msg", 'error' );
            }
            // redirect
            session()->flash('toast', $message);
            
            return redirect('branches');
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
        $branch = Branch::findOrFail($id);

        return view('branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        if(isSuperAdmin()) {
            $companies = Company::getDropDownList();
        }
        $countries = Country::pluck('name', 'country_code')->prepend('Select a Country', '')->all();
        
        return view('branches.edit', compact('branch', 'companies','countries'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if(Branch::destroy($request->hdnResource)){
            $message = toastMessage('Branch has been successfully removed.','success');
        }else{
            $message = toastMessage('Branch has not been removed.','error');
        }

        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }
}
