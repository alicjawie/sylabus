<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends BaseController
{

    /**
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction(SessionInterface $session)
    {

        $session->clear();
        $session->start();

        $usos = $this->getUSOSService();
        $usos->requestToken($session);

        $this->addFlash(
            'error',
            $this->get('translator')->trans('LOGIN_ERROR')
        );
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/login/after-auth", name="login_after_auth")
     *
     * @param Request $request
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAfterUSOSAuthAction(Request $request, SessionInterface $session)
    {
        $usos = $this->getUSOSService();
        $result = $usos->afterAuth($session);

        if ($result and isset($result->id)) {
            $user = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")
                ->findOneBy(array('index' => $result->id))
            ;
            if ($user instanceof User) {
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);

                $this->get('session')->set('_security_main', serialize($token));

                $event = new InteractiveLoginEvent($request, $token);
                $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                return $this->redirectToRoute('homepage');
            }
        }
        $this->addFlash(
            'error',
            $this->get('translator')->trans('USER_NOT_FOUND_IN_SYLLABUS_SYSTEM')
        );
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/login/in-progress", name="login_in_progress")
     *
     * @param SessionInterface $session
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function USOSLoginInProgressAction(SessionInterface $session, Request $request)
    {
        $usos = $this->getUSOSService();
        $usos->authInProgress($session, $request);

        $this->addFlash(
            'error',
            $this->get('translator')->trans('LOGIN_ERROR')
        );

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/login/default", name="login_symfony_default")
     *
     * @param Request $request
     * @return Response
     */
    public function symfonyLoginAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {
        return $this->render('@FOSUser/Security/login.html.twig', $data);
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login 
        in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
