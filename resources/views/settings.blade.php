@extends('layouts.master')

@section('title') Setting @endsection

@section('content')
    
    <div class="row">
        <div class="col-md-12">
            
            {!! Form::model($options, ['url' => url('settings/save'), 'role'=>'form', 'class' => 'margin-top-20']) !!}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('week_starts_on','Week Starts On') !!}
                            {{--  
                            {!! Form::select('options[week_starts_on]', config('constants.days'), !empty($options['week_starts_on']) ? $options['week_starts_on'] : NULL,['class'=>'form-control chosen-select']) !!}
                            --}}
                            {!! Form::selectWeek() !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('date_format','Date Format') !!}
                            {!! Form::select('options[date_format]', config('constants.date_format'), !empty($options['date_format']) ? $options['date_format'] : NULL,['class'=>'form-control chosen-select']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('timezone','Timezone') !!}
                        {!! Form::select('options[timezone]', getTimezones(), !empty($options['timezone']) ? $options['timezone'] : NULL,['class'=>'form-control chosen-select']) !!}
                    </div>

                    <div class="col-sm-6">
                        {!! Form::label('day_off','Weekly Holidays') !!}
                        {!! Form::select('options[day_off][]', config('constants.days'), !empty($options['day_off']) ? array_map('intval', explode(',', $options['day_off'])) : NULL,['class'=>'form-control chosen-select', 'multiple' => 'multiple','data-placeholder' => 'Choose some days']) !!}
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('task_weight_scale','Task Weight Scale') !!}
                            <input id="task_weight_scale" type="range" name="options[task_weight_scale]" min="1" max="100" value="{{ !empty($options['task_weight_scale']) ? $options['task_weight_scale'] : 30 }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('financial_year','Financial Year') !!}
                        {!! Form::select('options[financial_year]', config('constants.financial_year'), !empty($options['financial_year']) ? $options['financial_year'] : NULL,['class'=>'form-control chosen-select']) !!}
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <strong>Audit System</strong>
                            <label class="radio-inline">
                                <input type="radio" name="options[audit_sytem]" value="enable"{{ !empty($options['audit_sytem']) && $options['audit_sytem'] == 'enable' ?  ' checked="checked"': ' checked="checked"' }}> Enable
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="options[audit_sytem]" value="disable"{{ !empty($options['audit_sytem']) && $options['audit_sytem'] == 'disable' ?  ' checked="checked"': '' }}> Disable
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('extended_time_1','Extended Time 1') !!}
                            {!! Form::number('options[extended_time_1]',!empty($options['extended_time_1']) ? $options['extended_time_1'] : 0,['class'=>'form-control','placeholder'=>'Extended Time 1', 'id' => 'extended_time_1', 'min'=>0]) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('extended_time_2','Extended Time 2') !!}
                            {!! Form::number('options[extended_time_2]',!empty($options['extended_time_2']) ? $options['extended_time_2'] : 0,['class'=>'form-control','placeholder'=>'Extended Time 2', 'id' => 'extended_time_2', 'min'=>0]) !!}
                        </div>
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-sm-12">
                        <button class="btn btn-info">Save Settings</button>
                    </div>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('custom-style')
{{-- Range Slider --}}
{!! Html::style($assets . '/plugins/rangeslider/rangeslider.css') !!}
@endsection

@section('custom-script')
{{-- Range Slider --}}
{!! Html::script($assets . '/plugins/rangeslider/rangeslider.min.js') !!}
<script>
    (function() {
        $('input[type="range"]').rangeslider({
             polyfill : false,
            onInit : function() {
                this.output = $( '<div class="range-output" />' ).insertAfter( this.$range ).html( this.$element.val() );
            },
            onSlide : function( position, value ) {
                this.output.html( value );
            }
        });
    })();
</script>
@endsection



