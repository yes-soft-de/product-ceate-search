<?php

namespace App\BusinessLogic;

use Symfony\Component\HttpFoundation\Request;

interface CrudI
{
    public function getSetData(Request $request);

    public function create(Request $request);

    public function update(Request $request);

    public function delete(Request $request);

    public function getPainting();

    public function getId();
}