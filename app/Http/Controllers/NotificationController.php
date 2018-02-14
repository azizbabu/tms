<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notification;

class NotificationController extends Controller
{
	/**
	 * Display a list of notifications
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
    public function __invoke(Request $request)
    {
    	$notifications = Notification::whereTo($request->user()->id)->latest('id')->get();

       	return view('notifications', compact('notifications'));
    }
}
