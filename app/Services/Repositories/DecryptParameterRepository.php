<?php

namespace App\Services\Repositories;

use App\Services\Interfaces\DecryptParameterRepositoryInterface;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class DecryptParameterRepository implements DecryptParameterRepositoryInterface
{
    public function getData($id, $message, $route)
    {
        try {
            $decrypt = Crypt::decrypt($id);

            return $decrypt;
        } catch (DecryptException $decryptException) {
            toast(title: $message, type: 'error')
                ->timerProgressBar();

            return redirect()->route($route);
        }
    }
}
