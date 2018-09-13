<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * Return only letters from string. Spaces are replaced with _
 */
function except_letters($string)
{
    $onlyLetters = mb_ereg_replace('[^\\p{L}\s]', '', $string);
    $onlyLetters = preg_replace('/([\s])\1+/', ' ', $onlyLetters);
    $onlyLetters = preg_replace('/\s/', '-', trim($onlyLetters));
    return $onlyLetters;
}
