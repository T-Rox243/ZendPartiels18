<?php
 
namespace Front\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Entity\Liste;
use Front\Entity\ListeProd;
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
    
    public function ajoutlisteAction(){
        $id_prod = $this->params()->fromRoute('id', 0);
        return new ViewModel(array('id_prod'=>$id_prod));
    }
    
    public function nouvellelisteAction(){
        if($user = $this->identity()){
            $id_prod = $this->params()->fromRoute('id', 0);
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
                    
                    $listeProd = new ListeProd();
                    $data = array();
                    $data['id_liste'] = $liste->getId();
                    $data['id_prod'] = $id_prod;
                    $listeProd->exchangeArray($data);
                    $this->getEntityManager()->persist($listeProd);
                    $this->getEntityManager()->flush();

                    return $this->redirect()->toRoute('liste');
                }
            }
            return array('form' => $form);
        }else{
            $this->redirect()->toRoute('compte');
        }
    }
    
    public function modificationlisteAction(){
        //faire authentification
        //récup id_util
        //formulaire liste
        //enregistrement
    }
 
    public function ficheAction()
    {
        
    }
}
