<?php
 
namespace Produit\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Produit\Entity\Produit;
use Produit\Form\ProduitForm;
use Doctrine\ORM\EntityManager;
 
class ProduitController extends AbstractActionController
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
            'produits' => $this->getEntityManager()->getRepository('Produit\Entity\Produit')->findAll(),
        ));
    }
 
    public function addAction()
    {
        $form = new ProduitForm();
        $form->get('submit')->setValue('Add');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $produit = new Produit();
            $form->setInputFilter($produit->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $produit->exchangeArray($form->getData());
                $this->getEntityManager()->persist($produit);
                $this->getEntityManager()->flush();
 
                // Redirect to list of produits
                return $this->redirect()->toRoute('produit');
            }
        }
        return array('form' => $form);
    }
 
    public function editAction()
    {
        $id_prod = (int) $this->params()->fromRoute('id_prod', 0);
        if (!$id_prod) {
            return $this->redirect()->toRoute('produit', array(
                'action' => 'add'
            ));
        }
 
        $produit = $this->getEntityManager()->find('Produit\Entity\Produit', $id_prod);
        if (!$produit) {
            return $this->redirect()->toRoute('produit', array(
                'action' => 'index'
            ));
        }
 
        $form  = new ProduitForm();
        $form->bind($produit);
        $form->get('submit')->setAttribute('value', 'Edit');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($produit->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $this->getEntityManager()->flush();
 
                // Redirect to list of produits
                return $this->redirect()->toRoute('produit');
            }
        }
 
        return array(
            'id_prod' => $id_prod,
            'form' => $form,
        );
    }
 
    public function deleteAction()
    {
        $id_prod = (int) $this->params()->fromRoute('id_prod', 0);
        if (!$id_prod) {
            return $this->redirect()->toRoute('produit');
        }
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
 
            if ($del == 'Yes') {
                $id_prod = (int) $request->getPost('id_prod');
                $produit = $this->getEntityManager()->find('Produit\Entity\Produit', $id_prod);
                if ($produit) {
                    $this->getEntityManager()->remove($produit);
                    $this->getEntityManager()->flush();
                }
            }
 
            // Redirect to list of produits
            return $this->redirect()->toRoute('produit');
        }
 
        return array(
            'id_prod'    => $id_prod,
            'produit' => $this->getEntityManager()->find('Produit\Entity\Produit', $id_prod)
        );
    }
}