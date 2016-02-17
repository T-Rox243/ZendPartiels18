<?php
 
namespace Admin\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Utilisateur;
use Admin\Form\UtilisateurForm;
use Doctrine\ORM\EntityManager;
 
class UtilisateurController extends AbstractActionController
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
        return new ViewModel(array(
            'utilisateurs' => $this->getEntityManager()->getRepository('Admin\Entity\Utilisateur')->findAll(),
        ));
    }
 
    public function addAction()
    {
        $form = new UtilisateurForm();
        $form->get('submit')->setValue('Add');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $utilisateur = new Utilisateur();
            $form->setInputFilter($utilisateur->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $utilisateur->exchangeArray($form->getData());
                $this->getEntityManager()->persist($utilisateur);
                $this->getEntityManager()->flush();
 
                // Redirect to list of utilisateurs
                return $this->redirect()->toRoute('utilisateur');
            }
        }
        return array('form' => $form);
    }
 
    public function editAction()
    {
        $id_util = (int) $this->params()->fromRoute('id_util', 0);
        if (!$id_util) {
            return $this->redirect()->toRoute('utilisateur', array(
                'action' => 'add'
            ));
        }
 
        $utilisateur = $this->getEntityManager()->find('Admin\Entity\Utilisateur', $id_util);
        if (!$utilisateur) {
            return $this->redirect()->toRoute('utilisateur', array(
                'action' => 'index'
            ));
        }
 
        $form  = new UtilisateurForm();
        $form->bind($utilisateur);
        $form->get('submit')->setAttribute('value', 'Edit');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($utilisateur->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $this->getEntityManager()->flush();
 
                // Redirect to list of utilisateurs
                return $this->redirect()->toRoute('utilisateur');
            }
        }
 
        return array(
            'id_util' => $id_util,
            'form' => $form,
        );
    }
 
    public function deleteAction()
    {
        $id_util = (int) $this->params()->fromRoute('id_util', 0);
        if (!$id_util) {
            return $this->redirect()->toRoute('utilisateur');
        }
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
 
            if ($del == 'Yes') {
                $id_util = (int) $request->getPost('id_util');
                $utilisateur = $this->getEntityManager()->find('Admin\Entity\Utilisateur', $id_util);
                if ($utilisateur) {
                    $this->getEntityManager()->remove($utilisateur);
                    $this->getEntityManager()->flush();
                }
            }
 
            // Redirect to list of utilisateurs
            return $this->redirect()->toRoute('utilisateur');
        }
 
        return array(
            'id_util'    => $id_util,
            'utilisateur' => $this->getEntityManager()->find('Admin\Entity\Utilisateur', $id_util)
        );
    }
}