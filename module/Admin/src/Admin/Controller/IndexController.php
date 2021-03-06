<?php
 
namespace Admin\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
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
 
    public function indexAction()
    {
        $categ = $this->getEntityManager()->getRepository('Admin\Entity\Categorie')->findAll();
        $this->layout()->setVariable('categories',$categ);
        return new ViewModel(array());
    }
}