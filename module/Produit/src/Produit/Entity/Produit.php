<?php
namespace Produit\Entity;
  
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
  
/**
 * A music produit.
 *
 * @ORM\Entity
 * @ORM\Table(name="produit")
 * @property string $artist
 * @property string $title
 * @property int $id_prod
 */
class Produit implements InputFilterAwareInterface 
{
    protected $inputFilter;
  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id_prod;
  
    /**
     * @ORM\Column(type="string")
     */
    protected $nom;
  
    /**
     * @ORM\Column(type="string")
     */
    protected $reference;
  
    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     */
    protected $url_img;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $bl_archive;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $bl_nouv;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $bl_best;


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
        $this->id_prod = $data['id_prod'];
        $this->nom = $data['nom'];
        $this->reference = $data['reference'];
        $this->description = $data['description'];
        $this->url_img = $data['url_img'];
        $this->prix = $data['prix'];
        $this->bl_archive = $data['bl_archive'];
        $this->bl_nouv = $data['bl_nouv'];
        $this->bl_best = $data['bl_best'];
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
                'name'     => 'id_prod',
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
 
            $inputFilter->add(array(
                'name'     => 'reference',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'description',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'url_img',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'prix',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Digits'),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'bl_archive',
                'required' => false,
                'validators' => array(
                    array(
                        'name'    => 'Boolean',
                    ),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'bl_nouv',
                'required' => false,
                'validators' => array(
                    array(
                        'name'    => 'Boolean',
                    ),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'bl_best',
                'required' => false,
                'validators' => array(
                    array(
                        'name'    => 'Boolean',
                    ),
                ),
            ));
 
            $this->inputFilter = $inputFilter;
        }
 
        return $this->inputFilter;
    }
}