<?php

namespace Ebram\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class MicrosoftResourceOwner implements ResourceOwnerInterface {

    protected $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->response['Id'];
    }

    public function toArray()
    {
        return $this->response;
    }
    
    public function getEmail()
    {
        return $this->response['EmailAddress'];
    }
    
    public function getName()
    {
        return $this->response['DisplayName'];
    }
}
