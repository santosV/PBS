<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Principal;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'preDispatch'), 2);

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function preDispatch(MvcEvent $e)
    {
        //$container = new Container('user');
        $uri = $e->getRequest()->getUri();
        $auth = new AuthenticationService();
        $identity = $auth->getStorage()->read();
        if($identity!=false && $identity!=null){
             //$session = new Container('user');
             if (strpos($uri, "register")) {
                $url = $e->getRouter()->assemble(array(), array('name' => 'website-main'));
                $response=$e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
             }
             //echo $session->user_id;
            // echo $container->userid; //return $this->redirect()->toUrl($this->getRequest()->getBaseUrl());
        }
        else
        {
            if (strpos($uri, "carrito") || strpos($uri, "ensaladas") || strpos($uri, "menu") || strpos($uri, "combo")) {
                $url = $e->getRouter()->assemble(array(), array('name' => 'users-login'));
                $response=$e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
            }
        }
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    'Website' => __DIR__ . '/src/' . 'Website',
                    'Store' => __DIR__ . '/src/' . 'Store',
                    'Users' => __DIR__ . '/src/' . 'Users',
                ),
            ),
        );
    }
}
