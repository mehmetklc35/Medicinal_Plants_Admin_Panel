<?php
if (!function_exists('unique_id')) {
    function unique_id() {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($chars);
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $randomString .= $chars[random_int(0, $charLength - 1)];
        }

        return $randomString;
    }
}
?>