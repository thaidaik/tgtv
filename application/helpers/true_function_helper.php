<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('convertMilion'))
{
    function convertMilion($price)
    {
        $pricedata = (float) $price / 1000000;
        $convert = $pricedata . ' m VND';
        return $convert;
    }

}
if ( ! function_exists('convertDateDMY'))
{
    function convertDateDMY($date)
    {
        $convertdate = date("d/m/Y", strtotime($date));
        return $convertdate;
    }

}
if ( ! function_exists('truncateWords'))
{
    function truncateWords($text, $limit, $ellipsis = '...') {
        $words = preg_split("/[\n\r\t ]+/", $text, $limit + 1, PREG_SPLIT_NO_EMPTY);
        if ( count($words) > $limit ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $ellipsis;
        }
        return $text;
    }
}
if ( ! function_exists('randomPassword'))
{
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
if ( ! function_exists('initials'))
{
    function initials($str) {
        $ret = '';
        foreach (explode(' ', $str) as $word)
            $ret .= strtoupper($word[0]);
        return $ret;
    }
}



