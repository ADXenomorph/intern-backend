<?php

namespace Roowix\Controller;

use Roowix\App\Request;
use Roowix\App\Response\Response;

interface ControllerInterface
{
    public function run(Request $request): Response;
}
