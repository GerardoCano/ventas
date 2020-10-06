<?php

namespace Product;

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
                Model\ProductTable::class => function($container) {
                    $tableGateway = $container->get(Model\ProductTableGateway::class);
                    return new Model\ProductTable($tableGateway);
                },
                Model\ProductTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Product());
                    //Aqui debemos de agregar el nombre de la tabla que queremos enlazar
                    return new TableGateway('products', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    //Se crea un factory(fabrica) propio
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ProductController::class => function($container) {
                    return new Controller\ProductController(
                        $container->get(Model\ProductTable::class)
                    );
                },
            ],
        ];
    }
}