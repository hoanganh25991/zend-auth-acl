<?php
namespace AuthAcl\Controller;

use AuthAcl\Form\LoginFilter;
use AuthAcl\Form\LoginForm;
use AuthAcl\Service\SimpleAuth;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Stdlib\ParametersInterface;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController{
    protected $loginForm;

    public function loginAction(){
        $this->loginForm = new LoginForm("loginForm");
        //add filer to loginForm
        $loginFilter = new LoginFilter();
        $this->loginForm->setInputFilter($loginFilter);
        //if method is POST, handle auth
        /** @var Request $request */
        $request = $this->getRequest();
        if($request->isPost()){
            /** @var ParametersInterface $data */
            $data = $request->getPost();
            $this->loginForm->setData($data);
            if($this->loginForm->isValid()){
                //handle on loginForm valid
                //call SimpleAuth without register it into ServiceManger
                $authService = new SimpleAuth();
                $user = $authService->auth($data);
                $debug = $user;
                if($user){
                    $sessionManager = new SessionManager();
                    $sessionStorage = new SessionArrayStorage();
                    $sessionManager->setStorage($sessionStorage);
                    $sessionContainer = new Container("AuthAcl", $sessionManager);
                    $sessionContainer->offsetSet("user", $user);
                    var_dump("push user into \$sessionContainer", $sessionContainer->offsetGet("user"));
                    $this->redirect()->toUrl('/');
                }
            }
        }
        //add variablesContainer to viewModel
        $variablesContainer = array();

        $variablesContainer['loginForm'] = $this->loginForm;

        $view = new ViewModel($variablesContainer);
        return $view;
    }

    public function joinAction(){
        $view = new ViewModel();
        return $view;
    }

    public function logoutAction(){
        $sessionManager = new SessionManager();
        $sessionStorage = new SessionArrayStorage();
        $sessionManager->setStorage($sessionStorage);
        $sessionContainer = new Container("AuthAcl", $sessionManager);
        $sessionContainer->offsetUnset("user");
        var_dump("unset user from \$sessionContainer");
        return $this->redirect()->toUrl('/login');
    }

}