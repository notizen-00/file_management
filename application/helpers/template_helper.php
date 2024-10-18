<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('load_template')) {
    function load_template($view_name, $title = '', $subtitle = '-', $data = [])
    {
        $CI = &get_instance(); // Get the CI instance

        // Load views
        $data['title'] = $title;
        $data['subtitle'] = $subtitle;
        $CI->load->view('layout/partial/header', $data);
        $CI->load->view('layout/partial/navbar');
        $CI->load->view('layout/partial/sidebar');
        $CI->load->view('layout/partial/topbar', $data['subtitle']);
        $CI->load->view($view_name, $data);
        $CI->load->view('layout/partial/footer');
    }
}