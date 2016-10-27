<?php
namespace TodoMove\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Todoist extends AbstractProvider
{
    public function getBaseAuthorizationUrl()
    {
        return 'https://todoist.com/oauth/authorize';
    }


    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://todoist.com/oauth/access_token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return "https://todoist.com/API/v7/sync?token={$token->getToken()}&sync_token=*&resource_types=[\"user\"]";
    }

    protected function getDefaultScopes()
    {
        return ['data:read_write'];
    }

    protected function getAuthorizationHeaders($token = null) {
        return [
            'X-Access-Token' => $token,
            'X-Client-ID' => $this->clientId,
        ];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['error'],
                isset($data['code']) ? (int) $data['code'] : $response->getStatusCode(),
                $response
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $user = new TodoistUser($response);

        return $user;
    }

}
