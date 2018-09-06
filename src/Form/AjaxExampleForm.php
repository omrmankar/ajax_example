<?php

/**
 * @file
 * Contains Drupal\ajax_example\AjaxExampleForm
 */

namespace Drupal\ajax_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class AjaxExampleForm extends FormBase
{
    
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'ajax_example_autotextfields';
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        
        // The box contains some markup that we can change on a submit request.
        $form['container']['box'] = array(
            '#type' => 'markup',
            '#markup' => '<h1>Show submited result</h1>'
        );
        
        
        // This container wil be replaced by AJAX.
        $form['container'] = array(
            '#type' => 'container',
            '#attributes' => array(
                'id' => 'box-container'
            )
        );
        
        
        $form['candidate_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Candidate Name:'),
            '#required' => TRUE
        );
        
        $form['candidate_surname'] = array(
            '#type' => 'textfield',
            '#title' => t('Candidate Surname:'),
            '#required' => TRUE
        );
        
        $form['submit'] = array(
            '#type' => 'submit',
            // The AJAX handler will call our callback, and will replace whatever page
            // element has id box-container.
            '#ajax' => array(
                'callback' => '::promptCallback',
                'wrapper' => 'box-container'
            ),
            '#value' => $this->t('Submit')
        );
        
        return $form;
    }
    
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
    }
    
    /**
     * Callback for submit_driven example.
     *
     * Select the 'box' element, change the markup in it, and return it as a
     * renderable array.
     *
     * @return array
     *   Renderable array (the box element)
     */
    public function promptCallback(array &$form, FormStateInterface $form_state)
    {
        // In most cases, it is recommended that you put this logic in form
        // generation rather than the callback. Submit driven forms are an
        // exception, because you may not want to return the form at all.
                         $element   = $form['container'];
        $element['box']['#markup'] = "My name is {$form_state->getValue('candidate_name')}" . " " . "{$form_state->getValue('candidate_surname')}";
        return $element;
    }
}

?>