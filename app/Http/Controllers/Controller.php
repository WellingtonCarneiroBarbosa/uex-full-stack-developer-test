<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    public function __construct(protected Request $request)
    {
    }

    protected function response(
        callable $web,
        ?callable $api = null
    ) {
        return $this->request->expectsJson() && $api !== null ? $api() : $web();
    }
}
