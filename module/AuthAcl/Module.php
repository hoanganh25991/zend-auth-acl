<?php
namespace AuthAcl;

use AuthAcl\Util\UniAcl;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Stdlib\ArrayUtils;

class Module{
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

    public function onBootstrap(MvcEvent $e){
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'checkUniAcl'
        ), 1);

    }

//    public function getSessionManager(){
//        $sessionManager = new SessionManager();
//        $sessionStorage = new SessionArrayStorage();
//        $sessionManager->setStorage($sessionStorage);
//        return $sessionManager;
//    }

    public function checkUniAcl(MvcEvent $event){
        $whereDoWeGo = "checkUniAcl";
        $routeMatch = $event->getRouteMatch();
        $route = $event->getRouteMatch()->getMatchedRouteName();
        $controller = $routeMatch->getParam('controller');
        //only handle on BackEnd\Controller\*
        if(strpos($controller, 'BackEnd\Controller') === true){
            //do sth
        }
        $uniAcl = new UniAcl();
        $uniAcl->initAcl();
        $sessionManager = new SessionManager();
        $sessionStorage = new SessionArrayStorage();
        $sessionManager->setStorage($sessionStorage);
        $sessionContainer = new Container("AuthAcl", $sessionManager);
        //login user or guest
        //by default, user is guest
        $userAcl = new GenericRole('guest');
        $firstResultSet = 'userrole => guest';
        $user = 'user => XXX';
        if($sessionContainer->offsetExists("user")){
            $user = $sessionContainer->offsetGet("user");
            var_dump("get user from \$sessionContainer", $user);
            $adpater = new Adapter(array(
                'driver' => 'Pdo',
                'dsn' => 'mysql:dbname=zend_form-validate;host=localhost',
                'username' => 'root',
                'password' => 'ifrc',
                'driver_options' => array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                )
            ));
            $sql = new Sql($adpater);
            $select = $sql->select();
            $select
                ->from('userrole')
                ->join('role', 'userrole.role_id = role.id')
                ->where(array(
                    "userrole.user_id" => $user['id'],
                ));
            $statement = $sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();
            $resultSet = ArrayUtils::iteratorToArray($result);
            $firstResultSet = $resultSet[0];
            $userAcl = new GenericRole($firstResultSet['rolename']);
        }
        var_dump(array(
            $whereDoWeGo,
            $controller,
            'route => '.$route,
            $user,
            $firstResultSet,
            $uniAcl->getRoles(),
            $uniAcl->getResources(),
            $uniAcl->userResources($userAcl)
        ));

        if(!$uniAcl->isAllowed($userAcl, new GenericResource($controller))){
            die('Permission denied');
        };
    }
}