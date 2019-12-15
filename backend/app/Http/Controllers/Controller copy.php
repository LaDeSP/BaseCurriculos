<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Manager;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $jwt;
    protected $manager;

    public function __construct(JWTAuth $jwt, Manager $manager)
    {
        $this->jwt = $jwt;
        $this->manager = $manager;
    }
}
