<?php

namespace Fluent\Socialite\Config;

use CodeIgniter\Config\BaseConfig;

class Socialite extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Third Party Services
     * --------------------------------------------------------------------------
     *
     * This file is for storing the credentials for third party services such
     * as Github, Facebook, Google and more. This file provides the de facto
     * location for this type of information, allowing packages to have
     * a conventional file to locate the various service credentials.
     */
    public $services = [];

    public function __construct()
    {
        $appConfig = new App();
        $baseURL = rtrim($appConfig->baseURL, '/');

        $this->services = [
            'google' => [
                'client_id'     => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect'      => $baseURL . '/auth/oauth/callback/google',
            ],
        ];
    }
}
