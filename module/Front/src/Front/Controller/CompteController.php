<?php
 
namespace Front\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Utilisateur;
use Front\Form\CompteForm;
use Front\Controller\AuthController;
use Doctrine\ORM\EntityManager;
 
class CompteController extends AbstractActionController
{
    protected $em;
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
 
    public function indexAction()
    {
        $utilisateur = $this->getEntityManager()->getRepository('Admin\Entity\Utilisateur')->findBy(array('id_util' => $this->identity()->id_util));
        return new ViewModel(array('utilisateur' => $utilisateur));
    }
 
    public function connexionAction()
    {
        $form = new CompteForm();
        $form->get('submit')->setValue('Connexion');
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            
            $auth = new AuthController($authService);
            $validAuth = $auth->loginAction($post->email, $post->password);
            if($validAuth){
                $this->redirect()->toRoute('compte');
            }
        }
        return new ViewModel(array('form' => $form));
    }
 
    public function deconnexionAction()
    {
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            
            $auth = new AuthController($authService);
            $auth->logoutAction();
            $this->redirect()->toRoute('front');
    }
    
    public function inscriptionAction()
    {
        $form = new CompteForm();
        $form->get('submit')->setValue('Inscription');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            if(($post->password == $post->confmotdepasse) && !empty($post->email)){
                $utilisateur = new Utilisateur();
                $form->setInputFilter($utilisateur->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $utilisateur->exchangeArray($form->getData());
                    $this->getEntityManager()->persist($utilisateur);
                    $this->getEntityManager()->flush();

                    // Redirect to list of utilisateurs
                    return $this->redirect()->toRoute('index');
                }
            }
        }
        return new ViewModel(array('form' => $form));
        //return array('form' => $form);
    }
 
    public function ficheAction()
    {
        
    }
}
