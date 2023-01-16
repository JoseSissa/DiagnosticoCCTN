<?php

namespace Infinitesimal;

interface SetupInterface
{
    public function setupOnAwake();

    public function setupContainer(\DI\Container $container);
}