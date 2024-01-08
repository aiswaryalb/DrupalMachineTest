<?php

/**
 * @file
 * A form to upload CSV files.
 */

namespace Drupal\person_data\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\migrate\Plugin\migrate\source\CSV;

class PersonDataUploadForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'person_data_upload_csv';
    }
    public function buildForm(array $form, FormStateInterface $form_state) {

        if (\Drupal::currentUser()->hasPermission('upload csv')) {
            $form['csv_file'] = [
                '#type' => 'file',
                '#title' => $this->t('Upload CSV File'),
                '#description' => $this->t('Upload a CSV file containing person data (name, id, location, age).'),
                '#upload_validators'  => array(
                    'file_validate_extensions' => array('csv'),
                  ),
              ];
          
              $form['submit'] = [
                '#type' => 'submit',
                '#value' => $this->t('Submit'),
              ];
        } 
        else {
            \Drupal::messenger()->addError($this->t('You do not have permission to upload csv files.'));
        }
        return $form;
    }
   /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form , FormStateInterface $form_state) {    
      try {
            \Drupal::messenger()->addMessage(t("File uploaded successfully."));  
        } 
    catch (\Exception $e) {
        \Drupal::messenger()->addError(t("Unable to upload file."));
    }
  }

}   