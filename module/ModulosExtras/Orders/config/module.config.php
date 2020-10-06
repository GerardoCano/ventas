<?php

namespace Order;

use Laminas\Router\Http\Segment;

return [
    
    'router' => [
        'routes' => [
            'order' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/order[/:action[/:id]]',
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
            'order' => __DIR__ . '/../view',
        ],
    ],
];