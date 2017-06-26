<?php

use Carbon\Carbon;


/**
 * Convert a Carbon date object to a String for the API.
 * This will keep all the dates universal when converting
 *
 * @param Carbon $date
 * @return string
 */
function convertDateForApi(Carbon $date)
{
    //return $date->toRfc2822String(); // Thu, 25 Dec 1975 14:15:16 -0500
    //return $date->timestamp;  // EPOC
    return $date->toDateTimeString(); // 2012-09-05 23:26:11
    //echo $date->toAtomString();   // 1975-12-25T14:15:16-05:00
}

/**
 * Get a carbon instance from a date or time, or now if null.
 *
 * @param mixed $time
 * @param mixed $timezone
 * @return \Carbon\Carbon
 */
function carbonize($time = null, $timezone = null)
{
    switch (true) {
        case $time instanceof Carbon:
            return $time->copy();
        case $time instanceof \DateTime:
            return Carbon::instance($time);
        case is_numeric($time):
            return Carbon::createFromTimestamp($time, $timezone);
        default:
            return new Carbon($time, $timezone);
    }
}

function currency($amount)
{
    $number = $amount / 100;
    return '$' . money_format('%i', $number);
}

function money($amount)
{
    $number = $amount / 100;
    return money_format('%i', $number);
}

/**
 * Convert money from UI into cents
 *
 * @param $amount
 * @return int|string
 */
function convertCurrencyToCents($amount)
{
    $amount = str_replace('$', '', $amount);
    $amount = str_replace(',', '', $amount);
    $amount = str_replace(' ', '', $amount);

    // If theres a . we need to account for that.
    $newAmount = explode('.', $amount);

    // No decimal places given
    if (sizeof($newAmount) == 1) {
        return $newAmount[0] . '00';
    } else {
        // Sometimes, a user could put a single decimal place
        // Eg. $11.5
        if(strlen($newAmount[1]) === 1) {
            return $newAmount[0] . $newAmount[1] . '0';
        }
    }

    return intval($newAmount[0] . $newAmount[1]);
}

function customSmallInput($label, $id, $req) {
    $req_label = '';

    if($req == '1')
    {
        $req_label = ' <span style="color: red">*</span>';
    }

    return '<label>'.$label. $req_label .'</label><input type="text" name="custom_response['.$id.']" class="form-control" required='.$req.'>';
}

function customTextarea($label, $id, $req) {
    $req_label = '';

    if($req == '1')
    {
        $req_label = ' <span style="color: red">*</span>';
    }

    return '<label>'.$label. $req_label .'</label><textarea name="custom_response['.$id.']" class="form-control" required='.$req.' rows="5"></textarea>';
}

function customSelect($label, $id, $req, $options)
{
    $req_label = '';

    if($req == '1')
    {
        $req_label = ' <span style="color: red">*</span>';
    }

    $str = '<label>'.$label. $req_label . '</label><select name="custom_response['.$id.']" class="form-control">';

    $array_options = explode(',', $options);

    foreach($array_options as $key => $val)
    {
        $str .= '<option value="'.trim($val).'">'.$val.'</option>';
    }

    $str .= '</select>';

    return $str;
}
