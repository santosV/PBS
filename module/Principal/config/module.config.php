<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(

            'website-main' => array(
                
                'type' => 'segment',
                'options' => array(
                    'route' => '[/:action][/]',
                    'defaults' => array(
                        'controller' => 'Website\Controller\Main',
                        'action' => 'index',
                    ),
                ),
            ),

            'website-menu' => array(
                
                'type' => 'segment',
                'options' => array(
                    'route' => '/productos[/]',
                    'defaults' => array(
                        'controller' => 'Website\Controller\Main',
                        'action' => 'menu',
                    ),
                ),
            ),

            'store-products' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/menu[/:action][/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Products',
                        'action' => 'list',
                    ),
                ),
            ),

            'store-salads' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/ensaladas[/:action][/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Salads',
                        'action' => 'create',
                    ),
                ),
            ),

            'store-combos' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/combo[/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Salads',
                        'action' => 'combo',
                    ),
                ),
            ),

            'store-combos2' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/combo2[/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Products',
                        'action' => 'combo2',
                    ),
                ),
            ),



            'store-car' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/carrito[/:action][/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Car',
                        'action' => 'view',
                    ),
                ),
            ),

            'users-login' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user-login[/:message][/]',
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'login',
                    ),
                ),
            ),

            'users-auth' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user-auth[/]',
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'auth',
                    ),
                ),
            ),

            'users-logout' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user-logout[/]',
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'logout',
                    ),
                ),
            ),

            'users-register' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user-register[/:message][/]',
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'register',
                    ),
                ),
            ),

            'users-profile' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user-profile[/]',
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'profile',
                    ),
                ),
            ),
            'users-update' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user-update[/]',
                    'defaults' => array(
                        'controller' => 'Users\Controller\User',
                        'action' => 'update',
                    ),
                ),
            ),

            'add-existing-salad' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/add-existing-salad[/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Car',
                        'action' => 'addexistingsalad',
                    ),
                ),
            ),

            'send-mail' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/send-mail[/]',
                    'defaults' => array(
                        'controller' => 'Website\Controller\Main',
                        'action' => 'contact',
                    ),
                ),
            ),

            'new-combo' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/new-combo[/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Salads',
                        'action' => 'newcombo',
                    ),
                ),
            ),

            'delete-salad' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/delete-salad[/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Salads',
                        'action' => 'delete',
                    ),
                ),
            ),
            'user-payment' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user-payment[/]',
                    'defaults' => array(
                        'controller' => 'Store\Controller\Car',
                        'action' => 'pay',
                    ),
                ),
            ),
            // 'users-confirm' => array(
            //     'type' => 'segment',
            //     'options' => array(
            //         'route' => '/confirmation-code[=:key][/]',
            //         'defaults' => array(
            //             'controller' => 'Users\Controller\User',
            //             'action' => 'confirm',
            //         ),
            //     ),
            // ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Website\Controller\Main'   => 'Website\Controller\MainController',
            'Store\Controller\Products' => 'Store\Controller\ProductsController',
            'Store\Controller\Salads'   => 'Store\Controller\SaladsController',
            'Store\Controller\Car'      => 'Store\Controller\CarController',
            'Users\Controller\User'      => 'Users\Controller\UserController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array (          
                 'ViewJsonStrategy',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
