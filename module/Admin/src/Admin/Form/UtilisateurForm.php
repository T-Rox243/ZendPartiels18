<?php
namespace Admin\Form;

use Zend\Form\Form;

class UtilisateurForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('utilisateur');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id_util',
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
            'name' => 'prenom',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Prénom',
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));

        $this->add(array(
            'name' => 'bl_acti',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Checkbox',
            ),
            'options' => array(
                'label' => 'Actif·ve',
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
