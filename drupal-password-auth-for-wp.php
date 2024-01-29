<?php
/*
Plugin Name: Drupal Password Auth for WP
Description: This plugin accepts Drupal 9 password hash as wordpress passwords and authnticate users. Please note this is for Legacy hash only.
Author: Techrays Labs Private Limited
Author URI: https://techrayslabs.com/
Version: 1.0
*/

function check_password_for_drupal($check, $password, $hash, $user_id)
{

    if (substr($hash, 0, 3) == '$S$') { //Backward competbility with old WordPress users or Users who changes their password in WordPress
        return drupal_check_password($password, $hash);
    }

    return $check;
}

add_filter('check_password', 'check_password_for_drupal', 10, 4);

// Function to check the Drupal password hash
function drupal_check_password($password, $hash)
{
    // Drupal 9 password hashing algorithm
    $type = substr($hash, 0, 3);
    $algo = 'sha512';
    switch ($type) {
        case '$S$':
            // A normal Drupal 9 password hash The first 12 characters of an existing hash are its setting string.
            $setting = substr($hash, 0, 12);

            if ($setting[0] != '$' || $setting[2] != '$') {
                return FALSE;
            }
            $count_log2 = strpos('./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', $setting[3]);
            // Stored hashes may have been crypted with any iteration count. However we do not allow applying the algorithm for unreasonable low and high values respectively.
            if ($count_log2 != enforceLog2Boundaries($count_log2)) {
                return FALSE;
            }
            $salt = substr($setting, 4, 8);
            // Hashes must have an 8 character salt.
            if (strlen($salt) != 8) {
                return FALSE;
            }

            // Convert the base 2 logarithm into an integer.
            $count = 1 << $count_log2;

            $hash = hash($algo, $salt . $password, TRUE);
            do {
                $hash = hash($algo, $hash . $password, TRUE);
            } while (--$count);

            $len = strlen($hash);

            $output = $setting . base64Encode($hash, $len);
            $expected = 12 + ceil((8 * $len) / 6);
            return (strlen($output) == $expected) ? substr($output, 0, 55) : FALSE;
        default:
            return FALSE;
    }
}

function enforceLog2Boundaries($count_log2)
{
    if ($count_log2 < 7) {
        return 7;
    } elseif ($count_log2 > 30) {
        return 30;
    }

    return (int) $count_log2;
}

function base64Encode($input, $count)
{
    $output = '';
    $i = 0;
    $ITOA64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    do {
        $value = ord($input[$i++]);
        $output .= $ITOA64[$value & 0x3f];
        if ($i < $count) {
            $value |= ord($input[$i]) << 8;
        }
        $output .= $ITOA64[($value >> 6) & 0x3f];
        if ($i++ >= $count) {
            break;
        }
        if ($i < $count) {
            $value |= ord($input[$i]) << 16;
        }
        $output .= $ITOA64[($value >> 12) & 0x3f];
        if ($i++ >= $count) {
            break;
        }
        $output .= $ITOA64[($value >> 18) & 0x3f];
    } while ($i < $count);

    return $output;
}
