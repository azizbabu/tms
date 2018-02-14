<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
    * Add or Update notification
    */
    public static function AddOrUpdate($obj) 
    {
    	if(empty($obj->id)) {
    		$notification = new Notification;
	    	$notification->resource_id 		= $obj->resource_id;
	    	$notification->type 	   		= $obj->type;
	    	$notification->title 	   		= $obj->title;
	    	$notification->short_description= $obj->short_description;
	    	$notification->from 			= $obj->from;
	    	$notification->to 				= $obj->to;
    	}else {
    		$notification = Notification::findOrFail($obj->id);
    		$notification->status 			= $obj->status;
    	}

    	return $notification->save();
    }
}
