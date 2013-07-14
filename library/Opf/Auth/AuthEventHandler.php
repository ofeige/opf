<?php

namespace Opf\Auth;

use Opf\Auth\Driver\DriverInterface;
use Opf\Event\Event;
use Opf\Event\HandlerInterface;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;
use Opf\Session\SessionInterface;
use Opf\Template\View;

class AuthEventHandler implements HandlerInterface
{
   protected $driver;
   protected $session;
   protected $request;
   protected $response;

   public function __construct(DriverInterface $driver,
                               SessionInterface $session,
                               RequestInterface $request,
                               ResponseInterface $response,
                               View $login)
   {
      $this->driver = $driver;
      $this->session = $session;
      $this->request = $request;
      $this->response = $response;
      $this->login = $login;
   }

   public function handle(Event $event)
   {
      /** check if we should do a logout */
      if ($this->request->issetParameter('auth::logout')) {
         $this->logout();
      }


      /** check if wie already logged on */
      if ($this->session->getParameter('registered') == true &&
         $this->session->getParameter('username') != ''
      ) {
         return true;
      }

      /** test validaton of username & passowrd */
      $auth = $this->driver->isValid(
         $this->request->getParameter('auth::username'),
         $this->request->getParameter('auth::password')
      );

      /** check if we are log in now */
      if ($auth === false) {
//         $authEvent = new AuthEvent();
//         $authEvent->setSuccess(false);
//         $authEvent->setError('Username password mismatch');

//         $event = EventDispatcher::getInstance()->triggerEvent('onLoginFailed', $authEvent, array($request->getParameter('auth::username'), $request->getParameter('auth::password')));

//         if($event->isCancelled() === false) {
            $this->login->assign('fieldUser', 'auth::username');
            $this->login->assign('fieldPassword', 'auth::password');
            $this->login->render($this->request, $this->response);
            $event->cancel();
//         }
         return false;
      }

      $this->session->setParameter('username', $this->request->getParameter('auth::username'));
      $this->session->setParameter('registered', true);

      return true;
   }
}