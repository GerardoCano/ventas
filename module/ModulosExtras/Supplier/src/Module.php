<?php

namespace Supplier;

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
                Model\SupplierTable::class => function($container) {
                    $tableGateway = $container->get(Model\SupplierTableGateway::class);
                    return new Model\SupplierTable($tableGateway);
                },
                Model\SupplierTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Supplier());
                    //Aqui debemos de agregar el nombre de la tabla que queremos enlazar
                    return new TableGateway('suppliers', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    //Se crea un factory(fabrica) propio
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\SupplierController::class => function($container) {
                    return new Controller\SupplierController(
                        $container->get(Model\SupplierTable::class)
                    );
                },
            ],
        ];
    }
}