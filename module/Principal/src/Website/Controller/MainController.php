<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Website\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MainController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function menuAction()
    {
    	return new ViewModel();
    }

    public function contactAction()
    {
        if($this->getRequest()->isPost())
        {
            $message = new \Zend\Mail\Message();
            $message->setBody($this->request->getPost("body"));
            $message->setFrom('noreply@bajasalads.com');
            $message->setSubject($this->request->getPost("name") . " (" . $this->request->getPost("from") . ")");
            $message->addTo('christian.ibarra931@gmail.com');

            $smtpOptions = new \Zend\Mail\Transport\SmtpOptions();
            $smtpOptions->setHost('smtp.gmail.com')
                        ->setConnectionClass('login')
                        ->setName('smtp.gmail.com')
                        ->setConnectionConfig(array(
                            'username'  => 'hitleremilio@gmail.com',
                            'password'  => 'mcdinero12321',
                            'ssl'       => 'tls',           
                        ));
            $transport = new \Zend\Mail\Transport\Smtp($smtpOptions);
            if($transport->send($message))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
