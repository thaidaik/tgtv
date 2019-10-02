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



