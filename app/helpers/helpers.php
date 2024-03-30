<?php

/* GET GENERAL SETTINGS*/
if (!function_exists('get_settings'))
{
    function get_settings()
    {
        $results = null;
        $settings = new \App\Models\GeneralSetting();
        $settings_data = $settings->first();

        if ($settings_data) { //update
            $results = $settings_data;

        } else {
            $settings->insert([ //insert
                'site_name' => 'Laravecom default',
                'site_email' => 'laravecom@default.test',
            ]);

            $new_settings_data = $settings->first();
            $results = $new_settings_data;
        }
        return $results;
    }
}

/* GET GENERAL SETTINGS*/
if (!function_exists('get_social_network'))
{
    function get_social_network()
    {
        $results = null;
        $social_network = new \App\Models\SocialNetwork();
        $social_network_data = $social_network->first();

        if ($social_network_data) { //se esiste la riga in social_networks restituisco quella
            $results = $social_network_data;

        } else { //se non esiste neanche una riga in social_networks, la creo con tutto NULL
            $social_network->insert([
                'facebook_url'  => null,
                'twitter_url'   => null,
                'instagram_url' => null,
                'youtube_url'   => null,
                'github_url'    => null,
                'linkedin_url'  => null,
            ]);

            $new_social_network_data = $social_network->first();
            $results = $new_social_network_data;
        }
        return $results;
    }
}
