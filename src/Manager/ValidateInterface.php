<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\Request;

interface ValidateInterface
{
    public function pantingValidator(Request $request, $type);
    public function requestValidator(Request $request, $type);
}