<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Supplier\Controller\SupplierController;
use Customer\Controller\CustomerController;
use Comida\Controller\ComidaController;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => SupplierController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'customer' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/customer[/:action]',
                    'defaults' => [
                        'controller' => CustomerController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'product' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/product[/:action]',
                    'defaults' => [
                        'controller' => ProductController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'comida' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/comida[/:action]',
                    'defaults' => [
                        'controller' => ComidaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
