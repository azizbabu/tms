<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function country_obj()
    {
    	return $this->belongsTo('App\Country', 'country', 'country_code');
    }

    public static function getDropDownList($prepend=true)
    {
        $companies = Company::pluck('title', 'id');
        if($prepend) {
            $companies = $companies->prepend('Select a Company', '');
        }
        $companies = $companies->all();

        return $companies;
    }

    /**
     * Get the company's created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }
}
