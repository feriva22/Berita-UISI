<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class GoogleAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        
        return $request->headers->has('Authorization');
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        $header = $request->headers->get('Authorization');
        $parts = explode(' ',$header);
        if(sizeof($parts) !== 2)
            return null;

        return $parts[1];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // todo
        if($credentials === null)
            return;
        
        $client  = new \Google_Client(['client_id' => $_ENV['GOOGLE_CLIENT_ID']]);
        $payload = $client->verifyIdToken($credentials);
        if ($payload) {
            //enable for G Suite only, described by hd in payload
            if(isset($payload['hd']) && 
                in_array($payload['hd'],['uisi.ac.id','student.uisi.ac.id'])){
                return new User($payload);
            }
        }

    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // todo
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;

    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
