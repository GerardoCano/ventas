<?php

namespace Customer;

use Laminas\Router\Http\Segment;

return [
    
    'router' => [
        'routes' => [
            'customer' => [
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
            'customer' => __DIR__ . '/../view',
        ],
    ],
];