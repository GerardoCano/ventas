<?php

namespace Customer;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{   
    //Se manda a llamar el getConfig() el cual carga el module.config.php
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\CustomerTable::class => function($container) {
                    $tableGateway = $container->get(Model\CustomerTableGateway::class);
                    return new Model\CustomerTable($tableGateway);
                },
                Model\CustomerTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Customer());
                    //Aqui debemos de agregar el nombre de la tabla que queremos enlazar
                    return new TableGateway('customers', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    //Se crea un factory(fabrica) propio
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\CustomerController::class => function($container) {
                    return new Controller\CustomerController(
                        $container->get(Model\CustomerTable::class)
                    );
                },
            ],
        ];
    }
}