<?php
 
namespace Admin\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Categorie;
use Admin\Form\CategorieForm;
use Doctrine\ORM\EntityManager;
 
class CategorieController extends AbstractActionController
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
            'categories' => $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll(),
        ));
    }
 
    public function addAction()
    {
        $form = new CategorieForm();
        $form->get('submit')->setValue('Add');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $categorie = new Categorie();
            $form->setInputFilter($categorie->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $categorie->exchangeArray($form->getData());
                $this->getEntityManager()->persist($categorie);
                $this->getEntityManager()->flush();
 
                // Redirect to list of categories
                return $this->redirect()->toRoute('categorie');
            }
        }
        return array('form' => $form);
    }
 
    public function editAction()
    {
        $id_categ = (int) $this->params()->fromRoute('id_categ', 0);
        if (!$id_categ) {
            return $this->redirect()->toRoute('categorie', array(
                'action' => 'add'
            ));
        }
 
        $categorie = $this->getEntityManager()->find('Admin\Entity\Categorie', $id_categ);
        if (!$categorie) {
            return $this->redirect()->toRoute('categorie', array(
                'action' => 'index'
            ));
        }
 
        $form  = new CategorieForm();
        $form->bind($categorie);
        $form->get('submit')->setAttribute('value', 'Edit');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($categorie->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $this->getEntityManager()->flush();
 
                // Redirect to list of categories
                return $this->redirect()->toRoute('categorie');
            }
        }
 
        return array(
            'id_categ' => $id_categ,
            'form' => $form,
        );
    }
 
    public function deleteAction()
    {
        $id_categ = (int) $this->params()->fromRoute('id_categ', 0);
        if (!$id_categ) {
            return $this->redirect()->toRoute('categorie');
        }
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
 
            if ($del == 'Yes') {
                $id_categ = (int) $request->getPost('id_categ');
                $categorie = $this->getEntityManager()->find('Admin\Entity\Categorie', $id_categ);
                if ($categorie) {
                    $this->getEntityManager()->remove($categorie);
                    $this->getEntityManager()->flush();
                }
            }
 
            // Redirect to list of categories
            return $this->redirect()->toRoute('categorie');
        }
 
        return array(
            'id_categ'    => $id_categ,
            'categorie' => $this->getEntityManager()->find('Admin\Entity\Categorie', $id_categ)
        );
    }
}