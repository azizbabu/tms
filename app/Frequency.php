<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frequency extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Get the fequencies's created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }

    public static function getDropDownList($prepend=true)
    {
        $frequencies = Frequency::whereStatus('approved')->pluck('title', 'id');
        if($prepend) {
            $frequencies = $frequencies->prepend('Select a Frequency', '');
        }
        $frequencies = $frequencies->all();

        return $frequencies;
    }
}
