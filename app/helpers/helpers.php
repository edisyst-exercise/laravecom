<?php

/* GET GENERAL SETTINGS*/
if (!function_exists('get_settings')) {
    function get_settings()
    {
        $results = null;
        $settings = new \App\Models\GeneralSetting();
        $settings_data = $settings->first();

        if ($settings_data) {
            $results = $settings_data;

        } else {
            $settings->insert([
                'site_name' => 'Laravecom default',
                'site_email' => 'laravecom@default.test',
            ]);

            $new_settings_data = $settings->first();
            $results = $new_settings_data;
        }
        return $results;
    }
}

// RIPRENDI DA 21:21
