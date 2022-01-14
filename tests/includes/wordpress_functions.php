<?php

declare(strict_types=1);

if (!function_exists('get_template_directory')) {
    function get_template_directory()
    {
        global $current_test_dir;

        return $current_test_dir;
    }
}

if (!function_exists('untrailingslashit')) {
    function untrailingslashit($string)
    {
        return rtrim($string, '/\\');
    }
}

if (!function_exists('esc_html')) {
    function esc_html($string)
    {
        return $string;
    }
}

if (!function_exists('do_action')) {
    function do_action($hook_name, ...$arg)
    {

    }
}

if (!function_exists('do_action_deprecated')) {
    function do_action_deprecated($hook_name, $args, $version, $replacement = '', $message = '')
    {

    }
}

if (!function_exists('apply_filters')) {
    function apply_filters($hook_name, $value)
    {
        global $vendi_test_filters;

        return $vendi_test_filters[$hook_name] ?? $value;
    }
}