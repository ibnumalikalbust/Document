<?php
if (!function_exists('addressip')) {
    function addressip($input)
    {
        $min = 1;
        $max = 254;
        $ip = 101111;
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
        $ip = 20001;
        $address = $ip + $input;
        return $address;
    }
}
