<?php

class vc {

    public function init() {
        add_theme_support('post-thumbnails');
    }

    public function __get($key) {
        if($this->loadVcClass($key)) {
            return new $key;
        }
    }
    
    private function loadVcClass($name) {
        $name = ucfirst($name);
        $path = 'helpers' . '/';
        
        if( is_readable($path . $name . '.php') ) {
            require_once $path . $name . '.php';
            
            if( class_exists($name) ) {
                return true;
            }
        }
        return false;
    }
    
    public function __call($key, $args) {
        if($this->loadVcClass($key)) {
            return call_user_func(array(new $key, 'def'), $args);
        }
    }

    public function cache($k, $time = "+1 hour", $v = NULL) {
        if (is_array($k)) {
            $k = md5(serialize($k));
        }
        if ($v === NULL) {
            $time_c = get_option("cache_" . $k . "_time", 1);
            if (strtotime($time, $time_c) < strtotime("now")) {
                return false;
            }
            $res = get_option("cache_" . $k, 1);
            if (is_array(unserialize($res))) {
                $res = unserialize($res);
            }
            return $res;
        } else {
            $ov = $v;
            if (is_array($v)) {
                $v = serialize($v);
            }
            update_option("cache_" . $k, $v);
            update_option("cache_" . $k . "_time", strtotime("now"));
            return $ov;
        }
    }

    public function get_url($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com/");
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.001 (windows; U; NT4.0; en-US; rv:1.0) Gecko/25250101");
        $html = curl_exec($ch);
        curl_close($ch);
        if ($html) {
            if ($r = json_decode($html)) {
                $html = $r;
            }
        }
        return $html;
    }

}