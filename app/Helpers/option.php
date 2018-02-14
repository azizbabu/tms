<?php

use App\Option;

function getOption($name, $companyId=''){
	if(empty($companyId)){
		$companyId = Auth::user()->company_id;
	}

	$option = Option::whereCompanyId($companyId)->whereName($name)->first(['value']);

	return !empty($option->value) ? $option->value : '';

}

function getAllOption(){
	$companyId = Auth::user()->company_id;

	$options = Option::whereCompanyId($companyId)->get(['name','value']);

	if(!$options){
		return [];
	}

	$myOptions = [];
	foreach ($options as $option) {
		$myOptions[$option->name] = $option->value;
	}

	return $myOptions;
}

function addOrUpdateOption($name, $value){
	$companyId = Auth::user()->company_id;

	$option = Option::whereCompanyId($companyId)->whereName($name)->first();

	if(!$option){
		$option = new Option();
		$option->company_id = $companyId;
		$option->name = $name;
	}
	$option->value = $value;

	return $option->save() ? true : false;
}

function deleteOption($name){
	$companyId = Auth::user()->company_id;

	$option = Option::whereCompanyId($companyId)->whereName($name)->first();

	if(!$option){
		//no option found in db to delete
		return false;
	}

	return $option->delete() ? true : false;
}

function setupDefaultSettings($company_id)
{
	$default_settings = config('constants.default_settings');
	foreach($default_settings as $key=>$value) {
		$option = new Option();
		$option->company_id = $company_id;
		$option->name = $key;
		$option->value = $value;
		$option->save();
	}

	return true;
}