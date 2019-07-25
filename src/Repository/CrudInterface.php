<?php

namespace App\Repository;

use Symfony\Component\HttpFoundation\Request;

interface CrudInterface
{
    public function getSetData(Request $request, $panting);

    public function create(Request $request);

    public function update(Request $request);

    public function delete(Request $request);

    public function getPainting();

    public function getId();
}