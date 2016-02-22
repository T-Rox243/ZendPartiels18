<?php
 
namespace Front\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Entity\Front;
use Front\Form\FrontForm;
use Doctrine\ORM\EntityManager;
 
class IndexController extends AbstractActionController
{
    protected $em;
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    
    /*public function getListeCateg(){
        $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll();
    }*/
 
    public function indexAction()
    {
        $categ = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll();
        $this->layout()->setVariable('categories',$categ);
        $produits = $this->getEntityManager()->getRepository('Admin\Entity\Produit')->findAll();
        return new ViewModel(array($produits));
    }
}
