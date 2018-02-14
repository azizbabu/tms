<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OptionController extends Controller
{
	/**
	 * Display a form of settings 
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
    public function index(Request $request)
    {
    	$options = getAllOption();
    	
    	return view('settings', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
    	if($request->has('options')) {
    		$arr_val = '';
	    	foreach($request->options as $key=>$value) {
	    		if(is_array($value)) {
	    			addOrUpdateOption($key, implode(',',$value));
	    		}else {
	    			addOrUpdateOption($key, $value);
	    		}
	    	}
	    	session()->flash('toast', toastMessage('Setting information has been updated'));
    	}

    	return redirect()->back();
    }
}
