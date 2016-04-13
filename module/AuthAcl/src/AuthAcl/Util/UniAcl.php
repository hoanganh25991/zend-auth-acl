<?php
namespace AuthAcl\Util;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;

class UniAcl extends Acl{
    protected $commonResources = array(
        'FrontEnd\Controller\Index',
        'AuthAcl\Controller\Index'
    );

    public function initAcl(){
        //guest
        $roleGuest = new GenericRole('guest');
        $this->addRole($roleGuest);
//        //editor
        $roleEditor = new GenericRole('editor');
        $this->addRole($roleEditor, $roleGuest);
//        //admin
        $roleAdmin = new GenericRole('admin');
        $this->addRole($roleAdmin, $roleEditor);

        //add guest-resource
        $guestResources =$this->addResources($this->commonResources);
//        var_dump($guestResources);
        $this->allow($roleGuest, $guestResources);
        //add editor-privilege
        $editorPrivilege = array(
            'CheckList\Controller\Task',
            'FrontEnd\Controller\Keep',
            'FrontEnd\Controller\Calm'
        );
        $editorResource = $this->addResources($editorPrivilege);
        $this->allow($roleEditor, $editorResource);
        //add admin-privilege
        $adminPrivilege = array(
            'FrontEnd\Controller\Try',
            'FrontEnd\Controller\Hard'
        );
        $adminResource = $this->addResources($adminPrivilege);
        $this->allow($roleAdmin, $adminResource);
    }

    private function addResources($resources){
        $array = array();
        foreach($resources as $resourceId){
            $genericResource = new GenericResource($resourceId);
            $array[] = $genericResource;
            $this->addResource($genericResource);
        }
        return $array;
    }

    public function userResources($role){
        $userResources = array();
        foreach($this->getResources() as $resource){
            if($this->isAllowed($role, $resource)){
                $userResources[] = $resource;
            }
        }
        return $userResources;
    }


}