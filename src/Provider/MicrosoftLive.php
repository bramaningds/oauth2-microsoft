<?php

namespace Ebram\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;
use UnexpectedValueException;
use InvalidArgumentException;

class MicrosoftLive extends GenericProvider
{
    use BearerAuthorizationTrait;

    public function __construct(array $options = [], array $collaborators = [])
    {
        $default = [
            'urlAuthorize'            => 'https://login.live.com/oauth20_authorize.srf',
            'urlAccessToken'          => 'https://login.live.com/oauth20_token.srf',
            'urlResourceOwnerDetails' => 'https://apis.live.net/v5.0/me',
            'scopeSeparator'          => ' ',
            'scopes'                  => ['openid', 'profile', 'email']
        ];

        $options = array_merge($default, $options);

        parent::__construct($options, $collaborators);
    }

    protected function createResourceOwner(Array $response, AccessToken $token)
    {
        return new MicrosoftResourceOwner($response);
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error'])) {
            throw new IdentityProviderException(
                $response->getReasonPhrase(),
                $response->getStatusCode(),
                $data
            );
        }

        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $response->getReasonPhrase(),
                $response->getStatusCode(),
                (string) $response->getBody()
            );
        }
    }
}
