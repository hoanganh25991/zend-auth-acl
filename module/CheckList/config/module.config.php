<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'CheckList\Controller\Task' => 'CheckList\Controller\TaskController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'task' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/task[/:action[/:id]]',
                    'defaults' => array(
                        'controller' => 'CheckList\Controller\Task',
                        'action' => 'index',
                    ),
                    'constraints' => array(
                        'action' => '(add|edit|delete|json)',
                        'id' => '[0-9]+',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'avatar' => __DIR__.'/../view/check-list/avatar.phtml',
            'layout/checklist' => __DIR__.'/../view/check-list/layout.phtml',
            'layout/checklist/add' => __DIR__.'/../view/check-list/addLayout.phtml'

        ),
        'template_path_stack' => array(
            'check-list' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);