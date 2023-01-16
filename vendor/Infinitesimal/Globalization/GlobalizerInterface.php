<?php

namespace Infinitesimal\Globalization;

interface GlobalizerInterface
{
    public function globalize(string $key): string;
}