<?php

namespace Comida;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{   
    //Se manda a llamar el getConfig() el cual carga el module.config.php
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}