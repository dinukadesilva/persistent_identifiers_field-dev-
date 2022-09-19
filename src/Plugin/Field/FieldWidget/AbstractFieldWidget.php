<?php


namespace Drupal\persistent_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;


class AbstractFieldWidget extends WidgetBase
{

  public function getProvisionCallback()
  {
    return [$this, "myAjaxCallback"];
  }

  public function getFieldLabelPrefix(): string
  {
    return '';
  }

  public function onMint($entity): string
  {
    return 'sample-pid';
  }

  public function validate($element, FormStateInterface $form_state)
  {
    $value = $element['#value'];
    if (strlen($value) === 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function myAjaxCallback(array &$form, FormStateInterface $form_state)
  {

    $entity = $form_state->getFormObject()->getEntity();
    $triggering = $form_state->getTriggeringElement();
    $field_name = $triggering['#array_parents'][0];
    $value = $form_state->getValue($triggering['#parents']);
    $persistent_item_field = $entity->get($field_name);

    //dpm($sample_item_value);
    // //dpm($triggering);
    $triggering_element_no = $triggering['#parents'][1];
    //dpm($triggering_element_no) -- > 0;

    //dpm($value) --> 1;
    # Gets the field name

    //dpm($triggering);
    //dpm($field_name)-->field_art_sample;
    //$entity = $form_state->getFormObject()->getEntity();


    if ($value) {

      //dpm($entity) --> returns object;
      $pid = $this->onMint($entity);
      // $pid = \Drupal::service('persistent_identifiers.minter.uuid')->mint($entity, $form_state);
      //dpm($pid);
      if (is_null($pid)) {
        \Drupal::logger('persistent_fields')->warning(t("Persistent identifier not created for node @nid.", ['@nid' => $entity->id()]));
        \Drupal::messenger()->addWarning(t("Problem creating persistent identifier for this node. Details are available in the Drupal system log."));
        return;
      }
//      $persister = \Drupal::service('persistent_fields.persister');
//      //dpm($persister); -->Returns Object of the Service Class
//
//      if ($persister->persist($entity, $pid, $field_name, $save = FALSE)) {
//        \Drupal::logger('persistent_identifiers')->info(t("Persistent identifier %pid created for node @nid.", ['%pid' => $pid, '@nid' => $entity->id()]));
//        //     \Drupal::messenger()->addStatus(t("Persistent identifier %pid created for this node.", ['%pid' => $pid]));
//      } else {
//        \Drupal::logger('persistent_identifiers')->warning(t("Persistent identifier not created for node @nid.", ['@nid' => $entity->id()]));
//        \Drupal::messenger()->addWarning(t("Problem creating persistent identifier for this node. Details are available in the Drupal system log."));
//      }
//
      $form[$field_name]['widget'][$triggering_element_no]['persistent_item']['#value'] = $pid;
      //$form[$field_name]['widget'][$triggering_element_no]['sample_item']['#attributes']['disabled'] = TRUE;
      //$form[$field_name]['widget'][$triggering_element_no]['sample_minter_checkbox']['#attributes']['disabled'] = TRUE;
      //$sample_item_field->__set('node.article.'.$field_name.'sample_widget_container.sample_item',$pid);
    }


    return $form[$field_name]['widget'][$triggering_element_no];
  }


  /**
   * {@inheritdoc}
   */
  public function generateRandomString($length = 10)
  {
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
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
  {


    // Adds border element


    $random = $this->generateRandomString();

    $element += [
      '#type' => 'details',
      '#title' => $this->t('Persistent Field Wrapper'),
      '#open' => TRUE,
      '#attributes' => [
        "id" => "persistent-data-wrapper-$random"
      ]
    ];


    $element['persistent_item'] = array(
      '#title' => $this->t($this->getFieldLabelPrefix() . 'Item Field'),
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->persistent_item) ? $items[$delta]->persistent_item : NULL,
      '#attributes' => [
        "disabled" => isset($items[$delta]->persistent_item) || $form_state->getValue($form_state->getTriggeringElement()['#parents']) ? TRUE : FALSE,
      ],
      '#element_validate' => [
        [$this, 'validate'],
      ]
    );
    $element['persistent_minter_checkbox'] = array(
      '#title' => $this->t('Provision'),
      '#type' => 'checkbox',
      '#default_value' => isset($items[$delta]->persistent_item) ? TRUE : FALSE,
      '#ajax' => [
        // 'callback' =>  '\Drupal\persistent_fields\Plugin\Field\FieldWidget\SampleDefaultWidget::myAjaxCallback',
        'callback' => $this->getProvisionCallback(),
        'wrapper' => "persistent-data-wrapper-$random"
      ],
      '#attributes' => [
        "disabled" => isset($items[$delta]->persistent_item) ? TRUE : FALSE,
      ]

    );


    return $element;

  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state)
  {


    //dpm($values);
    foreach ($values as $delta => $value) {
      if ($value['persistent_item'] === '') {

        $values[$delta]['persistent_item'] = NULL;
      }
    }
    return $values;
  }


}
