<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;



if (!function_exists('get_version')) {

    /**
     * Translate with ucfirst
     *
     * @param  string  $name
     * @param  array   $parameters
     * @return string
     */
    function get_version() {
        if (file_exists(base_path('version'))) {
            $v = file_get_contents(base_path('version'));
            return trim($v);
        }
        return "";
    }

}


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('trans_uc')) {

    /**
     * Translate with ucfirst
     *
     * @param  string  $name
     * @param  array   $parameters
     * @return string
     */
    function trans_uc($id = null, $parameters = array(), $domain = 'messages', $locale = null) {
        return ucfirst(trans($id, $parameters, $domain, $locale));
    }

}

if (!function_exists('trans_choice_uc')) {

    /**
     * Translate with choice and with ucfirst
     *
     * @param  string  $name
     * @param  array   $parameters
     * @return string
     */
    function trans_choice_uc($id, $number, array $replace = [], $locale = null)
    {
        return ucfirst(trans_choice($id, $number, $replace, $locale));
    }

}


if (!function_exists('array_key_append')) {

    /**
     * Append or prepend a string to each key of an array.
     *
     * @param  array $array
     * @param  string $prefix
     * @param  boolean $append (append or prepend the prefix)
     * @return array
     */
    function array_key_append($array, $prefix, $append = true) {
        $new_keys = array();
        foreach (array_keys($array) as $key) {
            if ($append)
                $new_keys[] = $key . $prefix;
            else
                $new_keys[] = $prefix . $key;
        }
        return array_combine($new_keys, array_values($array));
    }

}

if (!function_exists('array_key_remove')) {

    /**
     * Append or prepend a string to each key of an array.
     *
     * @param  array $array
     * @param  string $prefix
     * @param  boolean $append (append or prepend the prefix)
     * @return string
     */
    function array_key_remove($array, $prefix, $append = true) {
        $new_array = array();
        foreach (array_keys($array) as $key) {

            if ($append && !Str::endsWith($key, $prefix)) {
                $new_array[$key] = $array[$key];
            }
            if (!$append && !Str::startsWith($key, $prefix)) {
                $new_array[$key] = $array[$key];
            }
        }
        return $new_array;
    }

}

if (!function_exists('array_undot')) {
    function array_undot($dotNotationArray)
    {
        $array = [];
        foreach ($dotNotationArray as $key => $value) {
            Arr::get($array, $key, $value);
        }
        return $array;
    }
}

if (!function_exists('preg_grep_keys')) {

    function preg_grep_keys($pattern, $input, $flags = 0) {
        return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
    }

}

if (!function_exists('trim_keys')) {

    function trim_keys($pattern, $input) {
        $new_array = array();
        foreach ($input as $key => $value) {
            $key2 = str_replace($pattern, '', $key);
            $new_array[$key2] = $value;
        }
        return $new_array;
    }

}

if (!function_exists('ltrim_keys')) {

    function ltrim_keys($pattern, $input) {
        $new_array = array();
        foreach ($input as $key => $value) {
            $key2 = ltrim($key,$pattern);
            $new_array[$key2] = $value;
        }
        return $new_array;
    }

}

if (!function_exists('searchform_trim_keys')) {

    function searchform_trim_keys($pattern, $input) {
        $new_array = array();
        foreach ($input as $key => $value) {
            if (Str::startsWith($key,$pattern)) {
                $key2 = substr($key,strlen($pattern));
                $new_array[$key2] = $value;
            }
        }
        return $new_array;
    }

}

if (!function_exists('trim_namespace')) {
    function trim_namespace($namespace, $input) {

        if (strstr($input,ltrim($namespace,"\\")))
            return substr($input,strlen(ltrim($namespace,"\\")));
        return $input;
    }

}


if (!function_exists('associative_from_input')) {

    function associative_from_input($input, $first_separator = ',', $second_separator = ':') {
        if (!$input || !is_string($input)) {
            return array();
        }
        $result = array();
        $first_tokens = explode($first_separator, $input);
        foreach ($first_tokens as $token) {
            $second_tokens = explode($second_separator, $token);
            if (count($second_tokens) === 1) {
                $result[] = $second_tokens;
                continue;
            }
            $result[$second_tokens[0]] = $second_tokens[1];
        }

        return $result;
    }

}

if (!function_exists('default_image_path')) {

    function default_image_path($inView = true) {
        $prefix = '';
        if (!$inView) {
            $prefix = public_path();
        }
        $theme = app('igaster.themes');
        $themUrl = $theme->url(Config::get('image.default_path',env('HOST_SUBPATH','').'/images/default.png'));
        return $prefix . $themUrl;
    }

}

if (!function_exists('cupparis_json_encode')) {
    function cupparis_json_encode($data)
    {
        $encodingOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;
        return json_encode($data, $encodingOptions);
    }
}

if (!function_exists('get_icona')) {

    function get_icona($mimetype) {
        $icona = Arr::get(Config::get('app.mimes_icone'),$mimetype,false);
        if ($icona)
            return $icona;
        else
            return  env('HOST_SUBPATH','').'/default.png';
    }

}

if (!function_exists('multi_rand')) {

    function multi_rand($nRandoms = 1,$min = 0,$max = 100) {

        $array = range($min, $max);
        $result = array();

        //Initialize the random generator
        srand ((double)microtime()*1000000);

        //A for-loop which selects every run a different random number
        for($x = 0; $x < $nRandoms; $x++)
        {
             //Generate a random number
             $i = rand(1, count($array))-1;

             //Take the random number as index for the array
             $result[] = $array[$i];

             //The chosen number will be removed from the array
             //so it can't be taken another time
             array_splice($array, $i, 1);
        }

        return $result;
    }

}
if (!function_exists('substr_text_only')) {
    function substr_text_only($string, $limit, $end = '...')
    {
        $notags = strip_tags($string);
        return Str::limit($notags,$limit,$end);
    }
}



if (!function_exists('storage_temp_path')) {

    /**
     * Get the path to the storage folder of the domain.
     *
     * @param   string  $path
     * @return  string
     */
    function storage_temp_path($path = '') {
        $id = Auth::id();
        if (!$id) {
            $id = 0;
        }

        return app('path.storage') . DIRECTORY_SEPARATOR . "files" .
            DIRECTORY_SEPARATOR . "temp/user_" . $id . ($path ? '/' . $path : $path);
    }

}

if (!function_exists('auth_role')) {

    /**
     * Get the path to the storage folder of the domain.
     *
     * @param   string  $path
     * @return  string
     */
    function auth_role($onlyname = true) {
        $user = Auth::user();
        if (!$user) {
            return null;
        }
        return $onlyname ? $user->getRolename() : $user->mainrole;
    }

}

if (!function_exists('auth_is_admin')) {

    /**
     * Get the path to the storage folder of the domain.
     *
     * @param   string  $path
     * @return  string
     */
    function auth_is_admin() {
        $role = auth_role();
        return ($role && in_array($role,config('permission.admin_roles',[])));
    }

}
