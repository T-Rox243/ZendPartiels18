<?php
 
namespace Front\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Entity\Categorie;
use Admin\Entity\CategProd;
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
        return new ViewModel(array());
    }
 
    public function listeAction()
    {
        
        $nom_categ = $this->params()->fromRoute('id', 0);
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $tC = new \Admin\Model\CategorieTable($dbAdapter);
        $categ = $tC->getCategByNom($nom_categ);
        
        $listprods = $this->getEntityManager()->getRepository('Admin\Entity\CategProd')->findBy(array('id_categ' => $categ->id_categ));
        $eP = $this->getEntityManager()->getRepository('Admin\Entity\Produit');
        $produits = array();
        foreach ($listprods as $prod){
            $produits[$prod->id_prod] = $eP->findBy(array('id_prod' => $prod->id_prod));
        }
        $categ = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll();
        $this->layout()->setVariable('categories',$categ);
        return new ViewModel(array('produits' => $produits));
    }
}
