<?php

if (!function_exists('load_lang')) {
    function load_lang($json) {
        if(!file_exists($json)) {
            return [];
        }
        return json_decode(file_get_contents($json), true);
    }
}
