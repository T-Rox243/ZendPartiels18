<?php
 
namespace Front\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Utilisateur;
use Front\Form\CompteForm;
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
        return new ViewModel(array());
    }
    
    public function inscriptionAction()
    {
        $form = new CompteForm();
        $form->get('submit')->setValue('Inscription');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            if(($post->motdepasse == $post->confmotdepasse) && !empty($post->email)){
                $utilisateur = new Utilisateur();
                $form->setInputFilter($utilisateur->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    echo 'test';exit;
                    $utilisateur->exchangeArray($form->getData());
                    $this->getEntityManager()->persist($utilisateur);
                    $this->getEntityManager()->flush();

                    // Redirect to list of utilisateurs
                    return $this->redirect()->toRoute('utilisateur');
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
