<?php

namespace Cporders;

use Laminas\Router\Http\Segment;

return [
    
    'router' => [
        'routes' => [
            'supplier' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/cporders/supplier[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\SupplierController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'customer' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/cporders/customer[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CustomerController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'product' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/cporders/product[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'order' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/cporders/order[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\OrderController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'supplier' => __DIR__ . '/../view',
            'customer' => __DIR__ . '/../view',
            'product' => __DIR__ . '/../view',
            'order' => __DIR__ . '/../view',
        ],
    ],
];