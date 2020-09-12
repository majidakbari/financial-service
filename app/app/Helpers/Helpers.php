<?php

if (!function_exists('get_class_name')) {
    function get_class_name($object)
    {
        if (is_object($object)) {
            $object = get_class($object);
        }
        return substr($object, strrpos($object, '\\') + 1);
    }
}
