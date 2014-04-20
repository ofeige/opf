<?php

namespace Opf\Auth;

use Opf\Auth\Driver\DriverInterface;
use Opf\Event\Event;
use Opf\Event\HandlerInterface;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;
use Opf\Session\SessionInterface;
use Opf\Template\ViewInterface;

class AuthEventHandler implements HandlerInterface
{
    protected $driver;
    protected $session;
    protected $request;
    protected $response;

    const authName   = 'auth::username';
    const authPassword = 'auth::password';
    const authLogout = 'auth::logout';
    const authSignin = 'auth::signin';

    public function __construct(
       DriverInterface $driver,
       SessionInterface $session,
       RequestInterface $request,
       ResponseInterface $response,
       ViewInterface $login
    )
    {
        $this->driver = $driver;
        $this->session = $session;
        $this->request = $request;
        $this->response = $response;
        $this->login  = $login;
    }

    public function handle(Event $event)
    {
        /** check if we should do a logout */
        if ($this->request->issetParameter(self::authLogout)) {
            $this->session->unsetParameter(self::authName);
            $this->session->unsetParameter(self::authSignin);
        }

        /**
         * $acl === false        <= no security
         * $acl === array()      <= security, but only signed-in
         * $acl === array('xx')  <= signed-in and user has role 'xx'
         */
        if (($acl = $event->getContext()->getAcl()) === false) {
            return true;
        }

        /** check if wie already logged on */
        if ($this->session->getParameter(self::authSignin) == true &&
           $this->session->getParameter(self::authName) != ''
        ) {
            return true;
        }

        /** test validation of username & password */
        $auth = $this->driver->isValid(
                             $this->request->getParameter(self::authName),
                             $this->request->getParameter(self::authPassword),
                             $acl
        );

        /** check if we are log in now */
        if ($auth === false) {
            $this->login->assign('action', '/?app=' . $this->request->getParameter('app'));
            $this->login->assign('fieldUser', self::authName);
            $this->login->assign('valueUser', $this->request->getParameter(self::authName));
            $this->login->assign('fieldPassword', self::authPassword);
            $this->login->render($this->request, $this->response);

            $event->cancel();

            return false;
        }

        $this->session->setParameter(self::authName, $this->request->getParameter(self::authName));
        $this->session->setParameter(self::authSignin, true);

        return true;
    }
}
