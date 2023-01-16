<?php

namespace Infinitesimal\Middleware;

interface Middleware
{
    public function run(): bool;
}