<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Illuminate\Http\RedirectResponse;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        return redirect('/email/verify');
    }
}
