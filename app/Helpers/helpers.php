
<?php

use Carbon\Carbon;

function greet()
{
    $hour = Carbon::now()->format('H');
    if ($hour < 11) {
        return 'Good morning';
    }
    if ($hour < 17) {
        return 'Good afternoon';
    }
    if ($hour < 19) {
        return 'Good evening';
    }
    if ($hour < 23) {
        return 'Good night';
    }
    if ($hour < 4) {
        return 'Go Sleep!';
    }
}

function greetCheck()
{
    $hour = Carbon::now()->format('H');
    if ($hour < 11) {
        return 'morning';
    }
    if ($hour < 17) {
        return 'afternoon';
    }
    if ($hour < 19) {
        return 'evening';
    }
    if ($hour < 23) {
        return 'night';
    }
    if ($hour < 4) {
        return 'sleep';
    }
}

function myEncrypt($val){
    $value = '28' . $val . '06';
    $encrypt_val = base64_encode($value);
    return $encrypt_val;
}

function getURL() {
    return request()->url();
}

function short_num( $n, $precision = 1 ) {
	if ($n < 1000) {
		// 0 - 1000
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 1000000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 1000000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 1000000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}

  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}

	return $n_format . $suffix;
}