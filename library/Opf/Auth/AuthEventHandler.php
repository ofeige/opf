<?php

namespace Opf\Auth;

use Opf\Auth\Driver\DriverInterface;
use Opf\Event\Event;
use Opf\Event\HandlerInterface;
use Opf\Event\Dispatcher;
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

    const authName     = 'auth::username';
    const authPassword = 'auth::password';
    const authLogout   = 'auth::logout';
    const authSignin   = 'auth::signin';
    const authRoles    = 'auth::roles';

    public function __construct(
        DriverInterface $driver,
        SessionInterface $session,
        RequestInterface $request,
        ResponseInterface $response,
        ViewInterface $login
    )
    {
        $this->driver   = $driver;
        $this->session  = $session;
        $this->request  = $request;
        $this->response = $response;
        $this->login    = $login;
    }

    public function handle(Event $event)
    {
        /** check if we should do a logout */
        if ($this->request->issetParameter(self::authLogout)) {
            $this->session->unsetParameter(self::authName);
            $this->session->unsetParameter(self::authSignin);

            $this->session->destroy();
        }

        /**
         * $roles === false        <= no security
         * $roles === array()      <= security, but only signed-in
         * $roles === array('xx')  <= signed-in and user has role 'xx'
         */
        if (($roles = $event->getContext()->getRoles()) === false) {
            return true;
        }

        /** check if user is already logged in, and no role is needed */
        if ($this->session->getParameter(self::authSignin) == true &&
            $this->session->getParameter(self::authName) != '' &&
            count($roles) == 0
        ) {
            return true;
        }

        /** check if user is already logged in, and role is needed */
        if ($this->session->getParameter(self::authSignin) == true &&
            $this->session->getParameter(self::authName) != '' &&
            count($roles) > 0 &&
            count(array_intersect(
                    $this->session->getParameter(self::authRoles),
                    $roles)) > 0
        ) {
            return true;
        }

        /** test validation of username & password */
        $auth = $this->driver->isValid(
            $this->request->getParameter(self::authName),
            $this->request->getParameter(self::authPassword),
            $roles
        );

        /** check if we are log in now */
        if ($auth === false) {
            $this->login->assign('uri', $this->request->getUri());
            $this->login->assign('fieldUser', self::authName);
            $this->login->assign('valueUser', $this->request->getParameter(self::authName));
            $this->login->assign('fieldPassword', self::authPassword);
            $this->login->assign('fieldRememberMeName', 'remember-me');
            $this->login->assign('fieldRememberMeValue', 1209600);
            $this->login->render($this->request, $this->response);

            $event->cancel();

            return false;
        }

        $this->session->start($this->request->getParameter('remember-me'));
        $this->session->setLifetime($this->request->getParameter('remember-me'));
        $this->session->setParameter(self::authName, $this->request->getParameter(self::authName));
        $this->session->setParameter(self::authSignin, true);
        $this->session->setParameter(self::authRoles,
            $this->driver->getRoles($this->request->getParameter(self::authName)));

        Dispatcher::getInstance()->triggerEvent(new Event('onLoginSuccess', array(self::authName => $this->request->getParameter(self::authName))));

        return true;
    }
}
