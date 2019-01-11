<?php

/**
 * Config module
 *
 * File: module.config.php:
 * 
 * @author Yevgeny Korobelnikov <kyss@meta.ua>
 * @module Comments
 */

namespace Comments;
 
use Zend\Router\Http\Segment; 
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    /*
    'controllers' => [
        'invokables' => [
            //Controller\CommentsController::class => InvokableFactory::class,
            //'Comments\Controller\Comments' => 'Comments\Controller\CommentsController', //InvokableFactory::class
        ],
    ],
    */
  
    'router' => [
        'routes' => [
            'comments' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/comments[page/:page]',                    
                    /*
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                 */
                    'defaults' => [
                        'controller' => Controller\CommentsController::class,
                        'action'     => 'index',
                        'page' => 1,
                    ],
                ],
            ],
        ],
    ],
 
    'view_helpers' => [    
        'factories' => [      
            View\Helper\Comments::class => InvokableFactory::class,          
            View\Helper\Datetime::class => InvokableFactory::class,          
            
        ],
        'aliases' => [
            'Comments' => View\Helper\Comments::class,
            'Datetime' => View\Helper\Datetime::class,
        ]
    ],
 
    
    'view_manager' => [
        'template_path_stack' => [
            'comments' => __DIR__ . '/../view',
        ],
    ],
];