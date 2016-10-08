<?php

namespace Ebram\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class MicrosoftLiveResourceOwner implements ResourceOwnerInterface {

    protected $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->response['id'];
    }

    public function toArray()
    {
        return $this->response;
    }

    public function getEmail()
    {
        return $this->response['emails']['account'];
    }

    public function getName()
    {
        return $this->response['name'];
    }

}
