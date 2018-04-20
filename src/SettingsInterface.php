<?php

namespace AxelSpringer\WP\S3;

interface SettingsInterface
{
    public function add_options_page();
    public function register_settings();
    public function admin_notices();
    public function admin_enqueue_scripts();
}