<?php

namespace AppBundle\Service;

use Doctrine\ORM\Mapping as ORM;
use OAuth;
use OAuthException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Router;

class USOSService
{
    /**
     * @var string
     */
    private $usosApiBaseUrl;
    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $consumerSecret;

    /** @var string  */
    private $selfUrl;

    /** @var array  */
    private $scopes = [];

    /** @var Router $router */
    private $router;

    /**
     * @var string $reqUrl
     */
    private $reqUrl;
    /** @var string $authUrl */
    private $authUrl;
    /** @var string $accUrl */
    private $accUrl;

    const BEFORE_AUTH = 'BEFORE_AUTH';
    const AUTH_IN_PROGRESS = 'AUTH_IN_PROGRESS';
    const AFTER_AUTH = 'AFTER_AUTH';

    public function __construct($consumerKey, $consumerSecret, $usosApiBaseUrl, $selfUrl, Router $router)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->usosApiBaseUrl = $usosApiBaseUrl;
        $this->selfUrl = $selfUrl;
        $this->router = $router;


        $this->reqUrl = $this->usosApiBaseUrl . 'services/oauth/request_token?scopes=' . implode("|", $this->scopes);
        $this->authUrl = $this->usosApiBaseUrl . 'services/oauth/authorize';
        $this->accUrl = $this->usosApiBaseUrl . 'services/oauth/access_token';
    }

    /**
     * @param SessionInterface $session
     * @return bool
     */
    public function requestToken(SessionInterface $session)
    {


        if (!$session->has('state')) {
            $session->set('state', self::BEFORE_AUTH);
        }
        try {
            $oauth = $this->getOAuth();
            $oauth->enableDebug();

            $request_token_info = $oauth->getRequestToken($this->reqUrl, $this->selfUrl.'?page=protected');
            $session->set('secret', $request_token_info['oauth_token_secret']);

            $session->set('state', self::AUTH_IN_PROGRESS);
            header(
                'Location: '. $this->authUrl . ((strpos($this->authUrl, '?') === false) ? '?' : '&') .
                'oauth_token=' . $request_token_info['oauth_token']
            );
            exit;
        } catch (OAuthException $E) {
            $session->clear();
            return false;
        }
    }

    /**
     * @param SessionInterface $session
     * @param Request $request
     */
    public function authInProgress(SessionInterface $session, Request $request)
    {
        $oauth = $this->getOAuth();

        if (!$request->query->has('oauth_token')) {
            header("Location: ". $this->router->generate('fos_user_security_login'));
            exit;
        }
        $oauth->setToken($request->query->get('oauth_token'), $session->get('secret'));
        $access_token_info = $oauth->getAccessToken($this->accUrl);
        $session->set('state', self::AFTER_AUTH);
        $session->set('token', $access_token_info['oauth_token']);
        $session->set('secret', $access_token_info['oauth_token_secret']);
        header('Location: '. $this->router->generate('login_after_auth'));
        exit;
    }

    /**
     * @param SessionInterface $session
     * @return mixed
     */
    public function afterAuth(SessionInterface $session)
    {
        try {
            $oauth = $this->getOAuth();

            $oauth->setToken($session->get('token'), $session->get('secret'));
            $oauth->fetch($this->usosApiBaseUrl .
                "services/users/user?fields=id|first_name|last_name|sex|homepage_url|profile_url");
            $json = json_decode($oauth->getLastResponse());

            return $json;
        } catch (OAuthException $E) {
            $session->clear();
            return false;
        }
    }

    /**
     * @return OAuth
     */
    private function getOAuth()
    {
        return new OAuth(
            $this->consumerKey,
            $this->consumerSecret,
            OAUTH_SIG_METHOD_HMACSHA1,
            OAUTH_AUTH_TYPE_URI
        );
    }
}
