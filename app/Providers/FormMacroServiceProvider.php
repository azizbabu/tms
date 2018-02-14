<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Form;

class FormMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::macro('selectWeek', function () {
            $days = [
                1    => 'Monday',
                2    => 'Tuesday',
                3    => 'Wednesday',
                4    => 'Thursday',
                5    => 'Friday',
                6    => 'Saturday',
                0    => 'Sunday',
            ];
            return Form::select('options[week_starts_on]', $days, !empty(getOption('week_starts_on')) ? getOption('week_starts_on') : NULL, ['class' => 'form-control chosen-select']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
