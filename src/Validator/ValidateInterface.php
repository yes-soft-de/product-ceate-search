<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;

interface ValidateInterface
{
    public function validateNewRequest(Request $request, $requestType);
}