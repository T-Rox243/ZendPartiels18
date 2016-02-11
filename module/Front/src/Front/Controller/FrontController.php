<?php
 
namespace Front\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Front\Entity\Front;
use Front\Form\FrontForm;
use Doctrine\ORM\EntityManager;
 
class FrontController extends AbstractActionController
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
            'front' => $this->getEntityManager()->getRepository('Front\Entity\Front')->findAll(),
        ));
    }
}
