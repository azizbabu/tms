<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Country extends Model
{
    public static function countryNames()
    {
		$result = DB::table('countries')->orderBy('name','asc')->pluck('name','country_code')->all();

		if($result){
			return $result;
		}else{
			return null;
		}
	}
}
