<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 04.10.16
 * Time: 22:43
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('morphem')) {
    function morphem($count, $form1, $form2, $form3) {
        $count = abs($count) % 100;
        $lcount = $count % 10;
        if ($count >= 11 && $count <= 19) return($form3);
        if ($lcount >= 2 && $lcount <= 4) return($form2);
        if ($lcount == 1) return($form1);
        return $form3;
    }
}