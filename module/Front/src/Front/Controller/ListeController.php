<?php
 
namespace Front\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Entity\Liste;
use Front\Form\ListeForm;
use Doctrine\ORM\EntityManager;
 
class ListeController extends AbstractActionController
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
        $listes = $this->getEntityManager()->getRepository('Front\Entity\Liste')->findBy(array('id_util' => $this->identity()->id_util));
        return new ViewModel(array('listes' => $listes));
    }
    
    public function nouvellelisteAction(){
        //faire authentification
        if($user = $this->identity()){
            $form = new ListeForm();
            $form->get('submit')->setValue('Ajouter');
            $form->get('id_util')->setValue($this->identity()->id_util);

            $request = $this->getRequest();
            if ($request->isPost()) {
                $liste = new Liste();
                $form->setInputFilter($liste->getInputFilter());
                $form->setData($request->getPost());

                if ($form->isValid()) {
                    $liste->exchangeArray($form->getData());
                    $this->getEntityManager()->persist($liste);
                    $this->getEntityManager()->flush();

                    // Redirect to list of produits
                    return $this->redirect()->toRoute('liste');
                }
            }
            return array('form' => $form);
        }else{
            $this->redirect()->toRoute('compte');
        }
        //récup id_util
        //formulaire liste
        //enregistrement
    }
    
    public function ajoutlisteAction(){
        //faire authentification
        //recup id_util
        //récup id_prod
        //récup id_liste
        //enregistrement
    }
 
    public function ficheAction()
    {
        
    }
}
