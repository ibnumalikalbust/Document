<?php
if (!function_exists('addressip')) {
    function addressip($input)
    {
        $min = 2;
        $max = 254;
        $ip = 272727;
        $modip = $input % $max;
        $numberaddip = $input / $max;
        if ($modip >= 1) {
            $exp = str_split($ip + $numberaddip, 2);
            $input = $modip + $min;
        } else if ($modip == 0) {
            $exp = str_split($ip + $numberaddip, 2);
            $input = $min;
        } else {
            $exp = str_split($ip, 2);
            $input = $input;
        }
        $address = $exp[0] . "." . $exp[1] . "." . $exp[2] . "." . $input;
        return $address;
    }
}

if (!function_exists('ip_number')) {
    function ip_number($input)
    {
        $min = 1;
        $max = 99;
        $ip = 27;
        $modip = $input % $max;
        $numberaddip = $input / $max;
        if ($modip >= 1) {
            $exp = str_split($ip + $numberaddip, 2);
            $input = $modip + $min;
        } else if ($modip == 0) {
            $exp = str_split($ip + $numberaddip, 2);
            $input = $min;
        } else {
            $exp = str_split($ip, 2);
            $input = $input;
        }
        $address = $exp[0] . sprintf("%02d", $input);
        return $address;
    }
}
