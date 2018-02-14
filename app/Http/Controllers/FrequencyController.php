<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Frequency;
use Validator;

class FrequencyController extends Controller
{
    /**
    * For user access control
    */
    public function __construct()
    {
        $this->middleware('department_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $frequencies = Frequency::latest('id')->paginate(10);
        $frequencies->paginationSummery = getPaginationSummery($frequencies->total(), $frequencies->perPage(), $frequencies->currentPage());

        return view('frequencies.index', compact('frequencies', 'branches'));
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
            'description'  => 'max:255',
        );

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
            return response()->json(['status' => 400, 'error' => $validator->errors()]);
        }else{
            // store
            $frequency = !$request->has('frequency_id') ? new Frequency : Frequency::findOrFail($request->frequency_id);
            $frequency->title = trim($request->title);
            $frequency->description = trim($request->description);
            if(!isSuperAdmin()) {
                $frequency->status = 'requested';
            }
            if(!$request->has('frequency_id')) {
                $msg = 'added';
                $frequency->created_by = $request->user()->id;
            }else {
                $msg = 'updated';
                $frequency->updated_by = $request->user()->id;
            }
            if($frequency->save()) { 
                
                return response()->json(['status' => 200, 'type' => 'success', 'message' => 'Frequency has been successfully '.$msg]);
            }else{
                
                return response()->json(['status' => 404, 'type' => 'error', 'message' => 'Frequency has not been successfully '.$msg]);
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
        $frequency = Frequency::findOrFail($id);

        return $frequency->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if(Frequency::destroy($request->hdnResource)){
            $message = toastMessage('Frequency has been successfully removed.','success');
        }else{
            $message = toastMessage('Frequency has not been removed.','error');
        }

        // Redirect
        session()->flash('toast',$message);
        
        return back();
    }

    /**
     * Change Status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        if(!isSuperAdmin()) {
            session()->flash('toast', toastMessage('You are not allowed to view this page', 'error'));

            return back();
        }

        $frequency = Frequency::findOrFail($request->hdnResource);

        if($frequency->status == 'requested') {
            $frequency->status = 'approved';
        }else {
            $frequency->status = 'requested';
        }
        if($frequency->save()) {
            $message = toastMessage('Frequency status has been set to '. $frequency->status);
        }else {
            $message = toastMessage('Frequency status has not been changed', 'error');
        }
        session()->flash('toast', $message);
        
        return back();
    }
}
