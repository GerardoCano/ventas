<?php

namespace Cporders;

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
                //Supplier TableGateway function
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

                //Customer TableGateway function
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

                //Product TableGateway function
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

                //Order TableGateway function
                Model\OrderTable::class => function($container) {
                    $tableGateway = $container->get(Model\OrderTableGateway::class);
                    return new Model\OrderTable($tableGateway);
                },
                Model\OrderTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Order());
                    //Aqui debemos de agregar el nombre de la tabla que queremos enlazar
                    return new TableGateway('orders', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    //Se crea un factory(fabrica) propio
    public function getControllerConfig()
    {
        return [
            'factories' => [
                //Supplier Controller function
                Controller\SupplierController::class => function($container) {
                    return new Controller\SupplierController(
                        $container->get(Model\SupplierTable::class)
                    );
                },

                //Customer Controller function
                Controller\CustomerController::class => function($container) {
                    return new Controller\CustomerController(
                        $container->get(Model\CustomerTable::class)
                    );
                },

                //Product Controller function
                Controller\ProductController::class => function($container) {
                    return new Controller\ProductController(
                        $container->get(Model\ProductTable::class)
                    );
                },

                //Order Controller function
                Controller\OrderController::class => function($container) {
                    return new Controller\OrderController(
                        $container->get(Model\OrderTable::class)
                    );
                },
            ],
        ];
    }
}