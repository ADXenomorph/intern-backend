<?php

namespace Controller;

use App\Request;
use App\Response\Response;

interface ControllerInterface
{
    public function run(Request $request): Response;
}
