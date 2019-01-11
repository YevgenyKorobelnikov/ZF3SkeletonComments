<?php
/**
 * Class Module
 *
 * File: Module.php
 * 
 * @author Yevgeny Korobelnikov <kyss@meta.ua>
 * @module Comments
 * composer require zendframework/zend-db
 */

namespace Comments;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;


class Module implements ConfigProviderInterface
{
    /*
    public function getAutoloaderConfig()
    {    
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    */
 
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
         return [
            'factories' => [
                Model\CommentsTable::class => function($container) {
                    $tableGateway = $container->get(Model\CommentsTableGateway::class);
                    return new Model\CommentsTable($tableGateway);
                },
                Model\CommentsTableGateway::class => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Comment());										                    
                    return new TableGateway('comments', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\CommentsController::class => function($container) {
                    return new Controller\CommentsController(
                        $container->get(Model\CommentsTable::class)
                    );
                },
            ],
        ];
    }
}
