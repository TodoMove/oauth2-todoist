<?php

namespace TodoMove\OAuth2\Client\Provider;


use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class TodoistUser implements ResourceOwnerInterface
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId()
    {
        return $this->data['user']['id'];
    }

    public function toArray()
    {
        return $this->data;
    }

    public function getEmail()
    {
        return $this->data['user']['email'];
    }

    public function getName()
    {
        return $this->data['user']['full_name'];
    }
}
