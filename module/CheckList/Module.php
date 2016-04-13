<?php
namespace CheckList;

use Checklist\Model\TaskMapper;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module{

    public function onBootstrap(MvcEvent $e){
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
//        $eventManager->attach('dispatch', array(
//          $this,
//          'setLayout'
//        ), 15);
        /**
         * RENDER STRATEGY
         * right before render output, change render type to JSONRender
         * by default PHPRender handle
         */
//        $eventManager->attach('render', array(
//            $this,
//            'renderJSONStrategy'
//        ), 1);
    }

    /**
     * method need PUBLIC, because it called by EventManager (some one out side this scope)
     * @param  \Zend\Mvc\MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function setLayout(MvcEvent $e){
        $matches = $e->getRouteMatch();//return array(length, param)
        $controller = $matches->getParam('controller');//return "Task"
        if(false === strpos($controller, "Task")){
            // not a controller from this module
            return;
        }

        // Set the layout template
        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('layout/checklist');
    }

    /**
     * method need PUBLIC, because it called by EventManager (some one out side this scope)
     * @param  \Zend\Mvc\MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function renderJSONStrategy(MvcEvent $e){
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        $action = $matches->getParam('action');
        if($action !== 'json'){
            //just handle for /task/json
            return;
        }
        // Potentially, you could be even more selective at this point, and test
        // for specific controller classes, and even specific actions or request
        // methods.

        // Set the JSON strategy when controllers from this module are selected
        $app = $e->getTarget();
        $locator = $app->getServiceManager();
        $view = $locator->get('Zend\View\View');
        $jsonStrategy = $locator->get('ViewJsonStrategy');

        // Attach strategy, which is a listener aggregate, at high priority
        $view->getEventManager()->attach($jsonStrategy, 1);
    }

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig(){
        return array(
            'factories' => array(
                'TaskMapper' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new TaskMapper($dbAdapter);
                    return $mapper;
                }
            ),
        );
    }
}