<?php
namespace FrontEnd\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController{
    public function indexAction(){
        $variablesContainer = array();
        $sessionManager = new SessionManager();
        $sessionStorage = new SessionArrayStorage();
        $sessionManager->setStorage($sessionStorage);
        $sessionContainer = new Container("AuthAcl", $sessionManager);
        if($sessionContainer->offsetExists("user")){
            $variablesContainer['@infor'] = "get user from \$sessionContainer";
            $variablesContainer['user'] = $sessionContainer->offsetGet("user");
        }
        $viewModel = new ViewModel($variablesContainer);
        return $viewModel;
    }
    public function abcAction(){
        return new ViewModel();
    }
}