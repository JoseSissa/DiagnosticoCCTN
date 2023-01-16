<?php

namespace Infinitesimal\Globalization\View;

use Infinitesimal\Globalization\Globalization;

class GlobalizedView
{
    protected function _(string $key)
    {
        return Globalization::globalize($key);
    }
}