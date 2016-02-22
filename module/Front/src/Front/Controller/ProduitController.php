<?php
 
namespace Front\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Produit;
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
        return new ViewModel(array());
    }
 
    public function ficheAction()
    {
        
        $id_prod = $this->params()->fromRoute('id', 0);
        
        $eP = $this->getEntityManager()->getRepository('Admin\Entity\Produit');
        $produit = $eP->findBy(array('id_prod' => $id_prod));
        
        $categ = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll();
        $this->layout()->setVariable('categories',$categ);
        return new ViewModel(array('produit' => $produit));
    }

    public function listeProduitsAction()
    {
        
        $id_prod = $this->params()->fromRoute('id', 0);
        
        $eP = $this->getEntityManager()->getRepository('Admin\Entity\Produit');
        $produit = $eP->findBy(array('id_prod' => $id_prod));
        
        return new ViewModel(array('produit' => $produit));
    }


}
