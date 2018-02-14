@extends('layouts.master')

@section('title') Edit Company @endsection 

@section('content')

{!! Form::model($company, array('url' => 'companies', 'role' => 'form','files' => true, 'id'=>'company-form')) !!}
	<div class="panel panel-default margin-top-20">
		<div class="panel-heading">
			<div class="panel-title">Edit Company</div>
		</div>
		<div class="panel-body">
			@include('companies.form')
		</div>
		<div class="panel-footer">
			{!! Form::hidden('file_remove', false) !!}
			{!! Form::hidden('company_id', $company->id) !!}
			<button class="btn btn-info"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
		</div>
	</div>		
{!! Form::close() !!}

@endsection

@section('custom-style')
{{-- Bootstrap Datepicker --}}
{!! Html::style($assets . '/plugins/datepicker/datepicker3.css') !!}
{{-- Jasny Bootstrap --}}
{!! Html::style($assets . '/plugins/jasny-bootstrap/jasny-bootstrap.min.css') !!}
@endsection

@section('custom-script')
{{-- Bootstrap Datepicker --}}
{!! Html::script($assets . '/plugins/datepicker/bootstrap-datepicker.js') !!}
{{-- Jasny Bootstrap --}}
{!! Html::script($assets . '/plugins/jasny-bootstrap/jasny-bootstrap.min.js') !!}
<script>
(function() {
    {{-- Initialize Datepicker --}}
    $('.datepicker').datepicker({
        autoclose:true,
        format:'yyyy-mm-dd',
    });

    $('.btn-remove').on('click', function() {
        $('input[name=file_remove]').val(true);
    });
})();
</script>
@endsection

