<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

interface ValidateInterface
{
    public function pantingValidator(Request $request);

}