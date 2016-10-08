<?php

namespace Ebram\OAuth2\Client\Service\Outlook;

use Ebram\OAuth2\Client\Provider\Microsoft;
use League\OAuth2\Client\Token\AccessToken;

class Message {

    private $provider;
    private $access_token;
    private $user_email;

    public function __construct(Microsoft $provider, AccessToken $access_token, $user_email)
    {
        $this->provider     = $provider;
        $this->access_token = $access_token;
        $this->user_email   = $user_email;
    }

    private function getDefaultHeader()
    {
        return ['X-AnchorMailbox' => $this->user_email];
    }

    private function createHeaders(Array $headers = [])
    {
        return $this->getDefaultHeader() + $headers;
    }
    
    private function getBaseUrl()
    {
        return "https://outlook.office.com/api/v2.0/me";
    }

    private function getEndpoint($folderId = null)
    {
        $url = $this->getBaseUrl();

        if ($folderId) {
            $url .= "/mailfolders/" . $folderId;
        }

        $url .= "/messages";

        return $url;
    }

    public function getList(Array $params = [])
    {
        $url        = $this->getEndpoint();
        $query      = http_build_query($params);
        
        $headers    = $this->createHeaders();

        $uri        = $url . '?' . $query;
        $options    = ["headers" => $headers];

        $request    = $this->provider->getAuthenticatedRequest("GET", $uri, $this->access_token, $options);
        $response   = $this->provider->getResponse($request);

        return $response;
    }

    public function getListInFolder($folderId, Array $params = [])
    {
        $url        = $this->getEndpoint($folderId);
        $query      = http_build_query($params);

        $headers    = $this->createHeaders();

        $uri        = $url . '?' . $query;
        $options    = ["headers" => $headers];

        $request    = $this->provider->getAuthenticatedRequest("GET", $uri, $this->access_token, $options);
        $response   = $this->provider->getResponse($request);

        return $response;
    }

    public function get($messageId, Array $params = [])
    {
        $url        = $this->getEndpoint();
        $query      = http_build_query($params);
        
        $headers    = $this->createHeaders();

        $uri        = $url . '/' . $messageId . '?' . $query;
        $options    = ["headers" => $headers];

        $request    = $this->provider->getAuthenticatedRequest("GET", $uri, $this->access_token, $options);
        $response   = $this->provider->getResponse($request);

        return $response;

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function move($messageId, $destinationId)
    {
        $url        = $this->getEndpoint();
        $query      = http_build_query($params);

        $headers    = $this->createHeaders(['content-type' => 'application/json']);
        $body       = json_encode(['DestinationId' => $destinationId]);

        $uri        = $url . '/' . $messageId . '/move?' . $query;
        $options    = ["headers" => $headers];

        $request    = $this->provider->getAuthenticatedRequest("GET", $uri, $this->access_token, $options);
        $response   = $this->provider->getResponse($request);

        return $response;
    }

    public function remove()
    {

    }
}
