<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class OAuthController extends AbstractController
{
    /**
     * Route qui redirige vers l'authentification
     * @param ClientRegistry $clientRegistry
     * @return RedirectResponse
     */
    #[Route('/oauth/login', name: 'oauth_login')]
    public function index(ClientRegistry $clientRegistry): RedirectResponse
    {
        return $clientRegistry->getClient('keycloak')->redirect();
    }
    
    /**
     * Route qui prend en charge la redirection du retour
     * @param Request $request
     * @param ClientRegistry $clientRegistry
     */
    #[Route('/oauth/callback', name: 'oauth_check')]
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry){
        
    }
    
    /**
     * Route vers le logout
     */
    #[Route('/logout', name: 'logout')]
    public function logout(){
        
    }
    
}
