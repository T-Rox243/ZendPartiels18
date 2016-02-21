<?php
namespace Front\Form;

use Zend\Form\Form;

class CompteForm extends Form
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
                'class' => 'form-control',
                'placeholder' => 'Nom',
            ),
            'options' => array(
            ),
        ));

        $this->add(array(
            'name' => 'prenom',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Prénom',
            ),
            'options' => array(
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Adresse email',
                'required' => true,
            ),
            'options' => array(
            ),
        ));

        $this->add(array(
            'name' => 'motdepasse',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control',
                'placeholder' => 'Mot de passe',
                'required' => true,
            ),
            'options' => array(
            ),
        ));

        $this->add(array(
            'name' => 'confmotdepasse',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control',
                'placeholder' => 'Confirmation du mot de passe',
                'required' => true,
            ),
            'options' => array(
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Inscription',
                'id' => 'submitbutton',
                'class' => 'btn btn-default',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
        ));

    }
}
