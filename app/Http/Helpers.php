<?php

use Hashids\Hashids;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



if (!function_exists('Num_into_Words')) {

    function Num_into_Words($num){
        $decones = array( '01' => "One", '02' => "Two", '03' => "Three", '04' => "Four", '05' => "Five", '06' => "Six", '07' => "Seven", '08' => "Eight", '09' => "Nine", 10 => "Ten",
            11 => "Eleven", 12 => "Twelve", 13 => "Thirteen", 14 => "Fourteen", 15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen"
        );
        $ones = array(
            0 => " ", 1 => "One", 2 => "Two", 3 => "Three", 4 => "Four", 5 => "Five", 6 => "Six", 7 => "Seven", 8 => "Eight", 9 => "Nine", 10 => "Ten",
            11 => "Eleven", 12 => "Twelve", 13 => "Thirteen", 14 => "Fourteen", 15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen"
        );
      $tens = array(
            0 => "", 2 => "Twenty", 3 => "Thirty", 4 => "Forty", 5 => "Fifty",6 => "Sixty", 7 => "Seventy", 8 => "Eighty", 9 => "Ninety"
        );
      $hundreds = array(
            "Hundred", "Thousand", "Million", "Billion", "Trillion", "Quadrillion"
        );
        //limit till quadrillion
        // format a number upto 2 decimals
        $num = number_format($num,2,".",",");
        $num_arr = explode(".",$num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",",$wholenum));
        // sorts an associative array in descending order
        krsort($whole_arr);
        $rettxt = "";
        // iterate through the array
        foreach($whole_arr as $key => $i){
            if($i < 20){
                $rettxt .= $ones[$i];
            }
            elseif($i < 100){
                // the substr function returns part of string
                $rettxt .= $tens[substr($i,0,1)];
                $rettxt .= " ".$ones[substr($i,1,1)];
            }
            else{
                $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
                $rettxt .= " ".$tens[substr($i,1,1)];
                $rettxt .= " ".$ones[substr($i,2,1)];
            }
            if($key > 0){
                $rettxt .= " ".$hundreds[$key]." ";
            }
      }
      // if float is found, show point
      if($decnum > 0){
            $rettxt .= " point ";
            if($decnum < 20){
                $rettxt .= $decones[$decnum];
            }
            elseif($decnum < 100){
                $rettxt .= $tens[substr($decnum,0,1)];
                $rettxt .= " ".$ones[substr($decnum,1,1)];
            }
      }
      return $rettxt;
    }
}

if (!function_exists('get_fulltime')) {

    function get_fulltime($date, $format = 'd, M Y @ h:i a')
    {
        $new_date = new \DateTime($date);
        return $new_date->format($format);
    }
}

if (!function_exists('get_date')) {
    function get_date($date)
    {
        return get_fulltime($date, 'D  d/m/Y');
    }
}

if (!function_exists('containsOnlyNull')) {
    function containsOnlyNull($input)
    {
        return empty(array_filter($input, function ($a) {
            return $a !== null;
        }));
    }
}

if (!function_exists('get_date_month')) {
    function get_date_month($date)
    {
        return get_fulltime($date, 'M Y');
    }
}


if (!function_exists('get_time')) {
    function get_time($date, $format = 'h:i A')
    {
        $new_date = new \DateTime($date);
        return $new_date->format($format);
    }
}

if (!function_exists('get_date_differences')) {
    function get_date_differences($start, $end, $interval = '1 month')
    {
        $start    = new \DateTime($start); // Today date
        $end      = new \DateTime($end); // Create a datetime object from your Carbon object
        $interval = \DateInterval::createFromDateString($interval); // 1 month interval
        $period   = new DatePeriod($start, $interval, $end); // Get a set of date beetween the 2 period

        return $period;
    }
}

if (!function_exists('get_price')) {

    function get_price($price)
    {
        return 'Rs: ' . number_format($price, 2);
    }
}

if (!function_exists("safeCount")) {
    function safeCount($array)
    {
        if (is_array($array) || is_object($array)) {
            return count($array);
        } else {
            return 0;
        }
    }
}







if (!function_exists('dummy_image')) {
    function dummy_image($type = null)
    {
        switch ($type) {
            case 'user':
                return asset('assets/images/avatars/avatar-1.png');
            default:
                return asset('assets/images/avatars/avatar-1.png');
        }
    }
}

if (!function_exists('check_file')) {
    function check_file($file = null, $type = null)
    {
        if ($file && $file != '' && file_exists($file)) {
            return asset($file);
        } else {
            return dummy_image($type);
        }
    }
}

if (!function_exists('hashids_encode')) {
    function hashids_encode($str)
    {
        $hashids = new Hashids('', 20);
        return $hashids->encode($str);
    }
}

if (!function_exists('hashids_decode')) {

    function hashids_decode($str)
    {
        try {
            $hashids = new Hashids('', 20);
            return $hashids->decode($str)[0];
        } catch (Exception $e) {
            return abort(404);
        }
    }
}

if (!function_exists('user_types')) {
    function user_types($index = null)
    {
        $arr = [
            "normal" => ['title' => 'Normal', 'class' => 'blue'],
            "admin" => ['title' => 'Admin', 'class' => 'danger'],
        ];
        if ($index) {
            return $arr[$index] ?? $arr['admin'];
        }
        return $arr;
    }
}

if (!function_exists('download_file')) {
    function download_file($file)
    {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            flush(); // Flush system output buffer
            readfile($file);
            die();
        }
        abort(404);
    }
}

if (!function_exists('ordinal')) {
    function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }

    if (!function_exists('getQuotientAndRemainder')) {
        function getQuotientAndRemainder($divisor, $dividend)
        {
            $quotient = (int)($divisor / $dividend);
            $remainder = $divisor % $dividend;
            return array('quotient' => $quotient, 'remainder' => $remainder);
        }
    }
}

if (!function_exists('get_states')) {
    function get_states()
    {
        $states = array([
            'name' => 'New South Wales',
            'abbreviation' => '(NSW)',
        ], [
            'name' => 'Victoria',
            'abbreviation' => '(VIC)',
        ], [
            'name' => 'Queensland',
            'abbreviation' => '(QLD)',
        ], [
            'name' => 'Tasmania',
            'abbreviation' => '(TAS)',
        ], [
            'name' => 'South Australia',
            'abbreviation' => '(SA)',
        ], [
            'name' => 'Western Australia',
            'abbreviation' => '(WA)',
        ], [
            'name' => 'Northern Territory',
            'abbreviation' => '(NT)',
        ], [
            'name' => 'Australian Capital Territory',
            'abbreviation' => '(ACT)',
        ]);
        return $states;
    }
}

if (!function_exists('convertToHoursMins')) {
    function convertToHoursMins($time)
    {
        $hours    = floor($time / 60);
        $minutes  = ($time % 60);
        if ($minutes == 0) {
            $output_format = $hours == 1 ? '%02d hour' : '%02d hours';
            $hoursToMinutes = sprintf($output_format, $hours);
        } else if ($hours == 0) {
            if ($minutes < 10) {
                $minutes = '0' . $minutes;
            }
            $output_format = $minutes == 1 ? '%02d min' : '%02d mins';
            $hoursToMinutes = sprintf($output_format,  $minutes);
        } else {
            $output_format = $hours == 1 ? '%02d hour %02d mins' : '%02d hours %02d mins';
            $hoursToMinutes = sprintf($output_format, $hours, $minutes);
        }

        return $hoursToMinutes;
    }
}

if (!function_exists('ads_check_counter')) {
    function ads_check_counter($item,$match) {
        $counter = 0;
        foreach ($item as $key => $value) {
            if ($match == $value) {
                $counter = $counter+1;
            }
        }
        return $counter;
    }
}

if (!function_exists('uploadSingleFile')) {
    function uploadSingleFile($file, $path = 'uploads/images/', $types = "png,gif,csv,jpeg,svg,jpg", $filesize = '20000', $rule_msgs = [])
    {
        $path = $path . date('Y') . '/';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        if ($types == 'application/pdf') {
            if ($filesize == null) {
                $rules = array('file' => 'required|mimes:' . $types);
            }else{
                $rules = array('file' => 'required|mimetypes:' . $types . "|max:" . $filesize);
            }
        }
        else{
            if ($filesize == null) {
                $rules = array('file' => 'required|mimes:' . $types);
            }else{
                $rules = array('file' => 'required|mimes:' . $types . "|max:" . $filesize);
            }
        }


        $validator = Validator::make(array('file' => $file), $rules, $rule_msgs);
        if ($validator->passes()) {
            $rand = time() . "_" . \Str::random(15) . "_";
            $f_name = $rand . $file->getClientOriginalName();
            $filename = $path . $f_name;
            //full size image
            $file->move($path, $f_name);
            return $filename;
        } else {
            return ['error' => $validator->errors()->first('file')];
        }
    }
}

// if (!function_exists('send_email')) {
//     function send_email($view, $to, $subject = 'Welcome !', $newdata, $from_email = null, $from_name = null)
//     {
//         $from_name = $from_name ?? env('MAIL_FROM_NAME');
//         $from_email = $from_email ?? env('MAIL_FROM_ADDRESS');

//         $data = array();
//         $data['subject'] = $subject;
//         $data['to'] = $to;
//         $data['from_name'] = $from_name;
//         $data['from_email'] = $from_email;
//         $data['email_data'] = $newdata;

//         try {
//             Mail::send('emails.' . $view, $data, function ($message) use ($data) {
//                 $message->from($data['from_email'], $data['from_name']);
//                 $message->subject($data['subject']);
//                 $message->to($data['to']);
//             });
//             return true;
//         } catch (\Exception $ex) {
//             return response()->json($ex);
//         }
//     }
// }
