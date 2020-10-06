<?php

namespace Supplier;

use Laminas\Router\Http\Segment;

return [
    
    'router' => [
        'routes' => [
            'supplier' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/supplier[/:action[/:id]]',
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
            'Customer' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/customer[/:action[/:id]]',
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
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'supplier' => __DIR__ . '/../view',
            'customer' => __DIR__ . '/../view',
        ],
    ],
];