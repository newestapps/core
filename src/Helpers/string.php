<?php

if (!function_exists('str_onlyASCII')) {

    /**
     * @param $input
     * @return string
     */
    function str_onlyASCII($input)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $input);
    }

}

if (!function_exists('str_searchable')) {

    /**
     * @param $input
     * @return string
     */
    function str_searchable($input)
    {
        return str_onlyASCII($input);
    }

}