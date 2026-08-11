<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse as Responsable;

class LogoutResponse implements Responsable {
    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
        return redirect()->route('home');
    }
}
