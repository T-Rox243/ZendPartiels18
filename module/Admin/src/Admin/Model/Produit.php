<?php

namespace Admin\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Produit implements InputFilterAwareInterface
{
    public $id_prod;
    public $nom;
    public $reference;
    public $description;
    public $url_img;
    public $prix;
    public $bl_archive;
    public $bl_nouv;
    public $bl_best;

    protected $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->id_prod     = (isset($data['id_prod'])) ? $data['id_prod'] : null;
        $this->nom = (isset($data['nom'])) ? $data['nom'] : null;
        $this->reference  = (isset($data['reference'])) ? $data['reference'] : null;
        $this->description  = (isset($data['description'])) ? $data['description'] : null;
        $this->url_img  = (isset($data['url_img'])) ? $data['url_img'] : null;
        $this->prix  = (isset($data['prix'])) ? $data['prix'] : null;
        $this->bl_archive  = (isset($data['bl_archive'])) ? $data['bl_archive'] : null;
        $this->bl_nouv  = (isset($data['bl_nouv'])) ? $data['bl_nouv'] : null;
        $this->bl_best  = (isset($data['bl_best'])) ? $data['bl_best'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id_prod',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'nom',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'reference',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'description',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 10000,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'url_img',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'prix',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'Digits',
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'bl_archive',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'Boolean',
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'bl_nouv',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'Boolean',
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'bl_best',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'Boolean',
                    ),
                ),
            )));


            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    }
}
