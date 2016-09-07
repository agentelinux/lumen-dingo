<?php

namespace App\Http\Middleware;


use Illuminate\Container\Container;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dingo\Api\Http\RateLimit\Throttle\Throttle;


class CustomThrottle extends Throttle

{

    protected $enabled;
    protected $options = [];

    public function __construct(array $options = [] , $enabled = true)

    {

        $this->enabled = $enabled;

        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;
        $this->options = ['limit' => $userId , 'expires' => 10];


        $this->options = array_merge($this->options, $options);

        parent::__construct($this->options);

    }

    public function match(Container $app)

    {

        return $this->enabled;

    }


}