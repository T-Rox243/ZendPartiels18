<?php
 
namespace Admin\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Caracteristique;
use Admin\Form\CaracteristiqueForm;
use Doctrine\ORM\EntityManager;
 
class CaracteristiqueController extends AbstractActionController
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
            'caracteristiques' => $this->getEntityManager()->getRepository('Admin\Entity\Caracteristique')->findAll(),
        ));
    }
 
    public function addAction()
    {
        $form = new CaracteristiqueForm();
        $form->get('submit')->setValue('Add');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $caracteristique = new Caracteristique();
            $form->setInputFilter($caracteristique->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $caracteristique->exchangeArray($form->getData());
                $this->getEntityManager()->persist($caracteristique);
                $this->getEntityManager()->flush();
 
                // Redirect to list of caracteristiques
                return $this->redirect()->toRoute('caracteristique');
            }
        }
        return array('form' => $form);
    }
 
    public function editAction()
    {
        $id_cara = (int) $this->params()->fromRoute('id', 0);
        if (!$id_cara) {
            return $this->redirect()->toRoute('caracteristique', array(
                'action' => 'add'
            ));
        }
 
        $caracteristique = $this->getEntityManager()->find('Admin\Entity\Caracteristique', $id_cara);
        if (!$caracteristique) {
            return $this->redirect()->toRoute('caracteristique', array(
                'action' => 'index'
            ));
        }
 
        $form  = new CaracteristiqueForm();
        $form->bind($caracteristique);
        $form->get('submit')->setAttribute('value', 'Edit');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($caracteristique->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $this->getEntityManager()->flush();
 
                // Redirect to list of caracteristiques
                return $this->redirect()->toRoute('caracteristique');
            }
        }
 
        return array(
            'id_cara' => $id_cara,
            'form' => $form,
        );
    }
 
    public function deleteAction()
    {
        $id_cara = (int) $this->params()->fromRoute('id', 0);
        if (!$id_cara) {
            return $this->redirect()->toRoute('caracteristique');
        }
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
 
            if ($del == 'Yes') {
                $id_cara = (int) $request->getPost('id_cara');
                $caracteristique = $this->getEntityManager()->find('Admin\Entity\Caracteristique', $id_cara);
                if ($caracteristique) {
                    $this->getEntityManager()->remove($caracteristique);
                    $this->getEntityManager()->flush();
                }
            }
 
            // Redirect to list of caracteristiques
            return $this->redirect()->toRoute('caracteristique');
        }
 
        return array(
            'id_cara'    => $id_cara,
            'caracteristique' => $this->getEntityManager()->find('Admin\Entity\Caracteristique', $id_cara)
        );
    }
}