<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use League\OAuth2\Client\Provider\Google;

class Users extends BaseController
{
    public function login_page():string
    {
        return $this->twig->render("login");
    }

    /////////////// OAUTH /////////////////
    private function getProvider(): Google
    {
        return new Google([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => env('GOOGLE_REDIRECT_URI'),
        ]);
    }

    public function login()
    {
        $provider = $this->getProvider();

        $authUrl = $provider->getAuthorizationUrl([
            'scope' => ['openid', 'email'],
        ]);

        // Stocke le state en session pour protection CSRF
        session()->set('oauth2_state', $provider->getState());

        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $request  = $this->request;
        $provider = $this->getProvider();

        // Vérif CSRF state
        $state        = $request->getGet('code') ? $request->getGet('state') : null;
        $sessionState = session()->get('oauth2_state');

        if (empty($state) || $state !== $sessionState) {
            session()->remove('oauth2_state');
            return redirect()->to('/')->with('error', 'State OAuth invalide.');
        }

        session()->remove('oauth2_state');

        $code = $request->getGet('code');

        if (! $code) {
            return redirect()->to('/')->with('error', 'Code OAuth manquant.');
        }

        try {
            // Échange le code contre un token
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $code,
            ]);

            // Récupère les infos utilisateur
            /** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
            $googleUser = $provider->getResourceOwner($token);

            // Check if user exists
            $existingUser = $this->userModel->where('google_id', $googleUser->getId())->first();

            $userData = [
                'google_id'   => $googleUser->getId(),
                'email'      => $googleUser->getEmail(),
                'display_name'       => $googleUser->getName(),
                'profile_picture_url'     => $googleUser->getAvatar(),
            ];

            if ($existingUser) {
                $this->userModel->update($existingUser['id'], $userData);
                $userId = $existingUser['id'];
            } else {
                // User does not exist: Create a new record
                $userData['created_at'] = date('Y-m-d H:i:s');
                $userId = $this->userModel->insert($userData);
            }

            $sessionData = [
                'isLoggedIn' => true,
                'user_id'    => $userId,
                'email'      => $userData['email'],
                'name'       => $userData['display_name'],
                'avatar'     => $userData['profile_picture_url'],
            ];

            session()->set('user', $sessionData);

            return redirect()->to('/');

        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            log_message('error', 'Google OAuth error: ' . $e->getMessage());
            return redirect()->to('/')->with('error', 'Authentification Google échouée.');
        }
    }

    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/login');
    }

    public function infos()
    {
        $user = session()->get('user');
        dd($user);
        return true;
    }

    public function dashboard()
    {
        $user = session()->get('user');
        if(!empty($user) && $user['isLoggedIn']) {
            return $this->twig->render("dashboard");
        } else {
            return redirect()->to('/login');
        }
    }
}
