<?php

namespace App\Services\Interfaces;

interface DecryptParameterRepositoryInterface
{
    public function getData($id, $message, $route);
}
