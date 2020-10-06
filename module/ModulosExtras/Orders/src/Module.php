<?php

namespace Order;

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
                Model\OrderTable::class => function($container) {
                    $tableGateway = $container->get(Model\OrderTableGateway::class);
                    return new Model\OrderTable($tableGateway);
                },
                Model\OrderTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Order());
                    return new TableGateway('order', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    //Se crea un factory(fabrica) propio
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\OrderController::class => function($container) {
                    return new Controller\OrderController(
                        $container->get(Model\OrderTable::class)
                    );
                },
            ],
        ];
    }
}