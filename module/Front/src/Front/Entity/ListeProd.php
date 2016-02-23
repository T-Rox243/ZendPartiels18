<?php
namespace Front\Entity;
  
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
  
/**
 * A music produit.
 *
 * @ORM\Entity
 * @ORM\Table(name="liste_prod")
 */
class ListeProd implements InputFilterAwareInterface 
{
    protected $inputFilter;
  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id_listeprod;
  
    /**
     * @ORM\Column(type="integer");
     */
    protected $id_liste;
    
    /**
     * @ORM\Column(type="integer");
     */
    protected $id_prod;
  
    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }
  
    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }
  
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }
  
    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function exchangeArray($data = array()) 
    {
        if(isset($data['id_listeprod'])){
            $this->id_listeprod = $data['id_listeprod'];
        }
        $this->id_liste = $data['id_liste'];
        $this->id_prod = $data['id_prod'];
    }
  
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
  
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
 
            $inputFilter->add(array(
                'name'     => 'id_liste',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'id_util',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
            
            $inputFilter->add(array(
                'name'     => 'nom',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
 
            $this->inputFilter = $inputFilter;
        }
 
        return $this->inputFilter;
    }
}