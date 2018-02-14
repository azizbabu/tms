<?php

use App\Country;

function getTimezones() 
{
    //flip key and value because user filters by full country name
    $countries = array_flip(Country::countryNames());
    $timezone_by_country = array();
    foreach ($countries as $country => $country_code)
    {
        //get all timezones by country code
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY,$country_code);
        $timezone_offsets = array();

        //for each timezone get UTC offset
        foreach( $timezones as $timezone )
        {
            $tz = new DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
        }

        //sort by offset, use ksort for sorting by timezone
        asort($timezone_offsets);

        $timezone_list = array();
        foreach( $timezone_offsets as $timezone => $offset )
        {
            //UTC - or UTC +
            $offset_prefix = $offset < 0 ? '-' : '+';
            //offset to 11:00 format
            $offset_formatted = gmdate( 'H:i', abs($offset) );
            //formatted string
            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
            
            //timezone to datetime
            $t = new DateTimeZone($timezone);
            $c = new DateTime(null, $t);
            //format hour:minute AM/PM
            $current_time = $c->format('g:i A');

            //remove underscores, dashes, continents/areas and add abbreviation periods
            $pretty_timezone = pretty_timezone_name($timezone);
            $timezone_list[$timezone] = "$current_time - $pretty_timezone (${pretty_offset})";
        }
        $timezone_by_country[$country] = $timezone_list;
    }

    return $timezone_by_country;
}

function pretty_timezone_name($name)
{
    $name = str_replace('/', ', ', $name);
    $name = str_replace('_', ' ', $name);
    $name = str_replace('St ', 'St. ', $name);
    $name = str_replace(
        array("America,","Pacific,","Asia,","Europe,","Antarctica,","Africa,","Atlantic,"),
        array(""),
        $name
    );
    return $name;
}