<?php

namespace SAAS\App\TwoFactor;

use SAAS\Domain\Users\Models\User;
use Exception;
use GuzzleHttp\Client;

class Authy implements TwoFactor
{
    /**
     * GuzzleHttp Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    public $client;

    /**
     * Authy constructor.
     *
     * @param \GuzzleHttp\Client $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Registers user to provider.
     *
     * @param User $user
     * @return mixed
     */
    public function register(User $user)
    {
        try {
            $response = $this->client->post(
                'https://api.authy.com/protected/json/users/new?api_key=' . config('services.authy.secret'), [
                    'form_params' => [
                        'user' => $this->getTwoFactorRegistrationDetails($user),
                    ],
                ]
            );
        } catch (Exception $e) {
            return false;
        }

        return json_decode($response->getBody(), false);
    }

    /**
     * Validates the user's token on register or login.
     *
     * @param User $user
     * @param $token
     * @return mixed
     */
    public function validateToken(User $user, $token)
    {
        try {
            $response = $this->client->get(
                'https://api.authy.com/protected/json/verify/' . $token . '/' . $user->twoFactor->identifier
                . '?force=true&api_key=' . config('services.authy.secret')
            );
        } catch (Exception $e) {
            return false;
        }

        $response = json_decode($response->getBody(), false);

        return $response->token === 'is valid';
    }

    /**
     * Deletes the user from the provider.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        try {
            $response = $this->client->post(
                'https://api.authy.com/protected/json/users/delete/' . $user->twoFactor->identifier
                . '?api_key=' . config('services.authy.secret')
            );
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Get the user details required by Authy.
     *
     * @param User $user
     * @return array
     */
    protected function getTwoFactorRegistrationDetails(User $user)
    {
        return [
            'email' => $user->email,
            'cellphone' => $user->twoFactor->phone,
            'country_code' => $user->twoFactor->dial_code,
        ];
    }
}
