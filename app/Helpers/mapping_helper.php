<?php

if (!function_exists("mapDatatablesFormat")) {
    function mapDatatablesFormat($data) {
        $output = array(
            "draw"              => 0,
            "recordsTotal"      => COUNT($data),
            "recordsFiltered"   => COUNT($data),
            "data"              => $data,
        );
        return $output;
    }
}

if (!function_exists("arrayGroupBy")) {
    function arrayGroupBy($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}