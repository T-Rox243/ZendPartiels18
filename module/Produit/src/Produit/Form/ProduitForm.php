<?php
namespace Produit\Form;

use Zend\Form\Form;

class ProduitForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('produit');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id_prod',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'nom',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Nom',
            ),
        ));

        $this->add(array(
            'name' => 'reference',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Reference',
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'  => 'textarea',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));

        $this->add(array(
            'name' => 'url_img',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Url de l\'image',
            ),
        ));

        $this->add(array(
            'name' => 'prix',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Prix',
            ),
        ));

        $this->add(array(
            'name' => 'bl_archive',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Checkbox',
            ),
            'options' => array(
                'label' => 'Archivé',
            ),
        ));

        $this->add(array(
            'name' => 'bl_nouv',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Checkbox',
            ),'options' => array(
                'label' => 'Nouveauté',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
        ));

        $this->add(array(
            'name' => 'bl_best',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Checkbox',
            ),
            'options' => array(
                'label' => 'Best Seller',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
        ));

    }
}
