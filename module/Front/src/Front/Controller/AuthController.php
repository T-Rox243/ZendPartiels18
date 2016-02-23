<?php
namespace Front\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationServiceInterface;

class AuthController extends AbstractActionController
{
    protected $authService;
   
    public function __construct(AuthenticationServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    
    public function loginAction($email,$mdp)
    {
        $auth = false;
        //you can grab this data from the Form in real life app
        $data['login'] = $email; 
        $data['password'] = $mdp;
        
        $authService = $this->authService;
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($data['login']);
        $adapter->setCredentialValue($data['password']);
        $authResult = $authService->authenticate();
    
        if ($authResult->isValid()) {
            $auth = true;
        }
        return $auth;
    }
    public function isAuthAction(){
        $isAuth = false;
        $sl = $this->getServiceLocator();
        $authService = $sl->get('doctrine.authenticationservice.orm_default');
        $user = $authService->getStorage()->read();  //is the user logged in?

        if ($user) {  //auth successful
            $isAuth = true;
        }
        return $isAuth;
    }
    
    public function logoutAction()
    {
        $authService = $this->authService;
        $authService->clearIdentity();
    }
}