<?php


namespace Drupal\persistent_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface; 

/**
 * Plugin implementation of the 'sample_field_widget' widget.
 *
 * @FieldWidget(
 *   id = "sample_field_widget",
 *   module = "persistent_fields",
 *   label = @Translation("Sample PID Widget"),
 *   field_types = {
 *     "persistent_fields_sample_item"
 *   }
 * )
 */
class SampleFieldWidget extends WidgetBase {




  /**
   * {@inheritdoc}
   */
  public function myAjaxCallback(array &$form, FormStateInterface $form_state) {
    


    $entity=$form_state->getFormObject()->getEntity();
    //dpm($entity);

    $triggering = $form_state->getTriggeringElement();
    //dpm($form['field_art_sample']['widget'][0]);
    //dpm($form['field_art_sample_2']['widget'][0]);
    $triggering_element_no = $triggering['#parents'][1];
    
    //dpm($triggering);
    $field_name = $triggering['#array_parents'][0];
    $value = $form_state->getValue($triggering['#parents']);
    //$sample_item_field=$entity->get($field_name);
    //dpm($field_name);
    //dpm($sample_item_value);
    // //dpm($triggering);
    
    //dpm($triggering_element_no) -- > 0;
    
    //dpm($value) --> 1;
    # Gets the field name
   
    //dpm($triggering);
    //dpm($field_name)-->field_art_sample;
    //$entity = $form_state->getFormObject()->getEntity();
    
   


    if($value){
      
      //dpm($entity) --> returns object;
      $pid = \Drupal::service('sample_minter.minter.sample')->mint($entity, $form_state);
      //dpm($pid);
      if (is_null($pid)) {
        \Drupal::logger('persistent_fields')->warning(t("Persistent identifier not created for node @nid.", ['@nid' => $entity->id()]));  
        \Drupal::messenger()->addWarning(t("Problem creating persistent identifier for this node. Details are available in the Drupal system log."));
        return;
      }
      $persister = \Drupal::service('persistent_fields.persister');
      //dpm($persister); -->Returns Object of the Service Class

      if ($persister->persist($entity, $pid, $field_name,$save=FALSE)) {
        \Drupal::logger('persistent_identifiers')->info(t("Persistent identifier %pid created for node @nid.", ['%pid' => $pid, '@nid' => $entity->id()]));
    //     \Drupal::messenger()->addStatus(t("Persistent identifier %pid created for this node.", ['%pid' => $pid]));
      }
    else {
    \Drupal::logger('persistent_identifiers')->warning(t("Persistent identifier not created for node @nid.", ['@nid' => $entity->id()]));
    \Drupal::messenger()->addWarning(t("Problem creating persistent identifier for this node. Details are available in the Drupal system log."));
    }
    
    $form[$field_name]['widget'][$triggering_element_no]['sample_item']['#value'] = $pid;
    //$form[$field_name]['widget'][$triggering_element_no]['sample_item']['#attributes']['disabled'] = TRUE;
    //$form[$field_name]['widget'][$triggering_element_no]['sample_minter_checkbox']['#attributes']['disabled'] = TRUE;
    //$sample_item_field->__set('node.article.'.$field_name.'sample_widget_container.sample_item',$pid);
    }
    
    
    
    return $form[$field_name]['widget'][$triggering_element_no];
  }


/**
 * {@inheritdoc}
 */
public function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}




  


  /**
 * {@inheritdoc}
 */
public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    
 
  // Adds border element
    //dpm($form_state);
    $random=$this->generateRandomString();

     $element += [
      '#type' => 'details',
      '#title' => $this->t('Persistent Field Wrapper'),
      '#open' => TRUE,
      '#attributes' => [
        "id" => "pid-data-wrapper-$random",
      ],

    ];
    
  
    
    $element['sample_item'] = array(
      '#title' => $this->t('Sample Item Field'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->sample_item) ? $items[$delta]->sample_item : NULL,
      '#attributes'=> [
        "disabled" => isset($items[$delta]->sample_item) ? TRUE:FALSE,
      ]
    );
    $element['sample_minter_checkbox']=array(
      '#title'=>$this->t('Checkbox for Sample Minter'),
      '#type'=>'checkbox',
      '#default_value'=> isset($items[$delta]->sample_item) ? TRUE:FALSE,
      '#ajax' => [
        // 'callback' =>  '\Drupal\persistent_fields\Plugin\Field\FieldWidget\SampleDefaultWidget::myAjaxCallback',
        'callback' =>  [$this,'myAjaxCallback'],
        'wrapper' => "pid-data-wrapper-$random"
      ],
      '#attributes'=> [
        "disabled" => isset($items[$delta]->sample_item) ? TRUE:FALSE,
      ]
  
    );
    
    
    return $element;
    
  }

   /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
   
   
    //dpm($values);
    foreach ($values as $delta => $value) {
      if ($value['sample_item'] === '') {
        
        $values[$delta]['sample_item'] = NULL;
      }
    }
    return $values;
  }
  







 


 }