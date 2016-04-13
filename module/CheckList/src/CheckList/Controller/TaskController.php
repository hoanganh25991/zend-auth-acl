<?php
namespace CheckList\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class TaskController extends AbstractActionController{
    public function indexAction(){
        $variableContainer = array();
        $coder = "<p>author: Anh Le Hoang - <code>^^</code></p>";
        $variableContainer['coder'] = $coder;
        //fast way to return $variableContainer, without $viewModel
        //bcs MvcEvent as fallback, bind $viewModel with $variableContainer
        //        return $variableContainer;
        $view = new ViewModel($variableContainer);
        //        $view->setTemplate('avatar');
        //avatar for authro
        //        $avatar = new ViewModel();
        $avatar =
            new ViewModel(array('avatarURL' => 'https://avatars0.githubusercontent.com/u/8801188?v=3&s=460'));
        //using defined template
        $avatar->setTemplate('avatar');
        //add 'avatar' to $view
        $view->addChild($avatar, 'avatar');
        //Disable layouts; `MvcEvent` will use this View Model instead
        //                $view->setTerminal(true);
        return $view;
    }

    public function addAction(){
        return parent::indexAction();
    }

    public function editAction(){
        return parent::indexAction();
    }

    public function deleteAction(){
        return parent::indexAction();
    }

    public function jsonAction(){
        /**
         * Change default PHPRender to JSONRender
         */
        //        $serviceLocator = $this->getServiceLocator();
        //        $view = $serviceLocator->get('Zend\View\View');
        //        $jsonStrategy = $serviceLocator->get('ViewJsonStrategy');
        $variableContainer = array();
        $data = json_encode(array(
            'coder' => array(
                'name' => 'Anh Le Hoang',
                'age' => '25',
                'major' => 'web developer'
            )
        ));
        $variableContainer['JSONData'] = $data;
        /**
         * try modify $htmlOutput FAIL
         */
        //        $view = new ViewModel($variableContainer);
        //        $htmlOutput = $this->getServiceLocator()->get('viewrenderer')->render('application/json', $view);
        //        return $htmlOutput;
        /**
         * try modify $acceptCriteria FAIL
         */
        //        $acceptCriteria = array(
        //            'Zend\View\Model\ViewModel' => array(
        //                'text/html',
        //            ),
        //            'Zend\View\Model\JsonModel' => array(
        //                'application/json',
        //            ));
        //
        //        $view = $this->acceptableViewModelSelector($acceptCriteria);
        //        $view->setVariables($variableContainer);
        //        return $view;

        /**
         * try modify directly into $response FAIL
         * return text/html @@
         */
        //        $this->response->setContent(json_encode($variableContainer));
        //        return $this->response;

        /**
         * try config for CheckList Module SUCCESS
         * view_manage => strategies => 'ViewJsonStrategy'
         * change ViewModel >>> JsonModel
         */
        $jsonView = new JsonModel(
            $variableContainer
        );
        return $jsonView;
    }

}