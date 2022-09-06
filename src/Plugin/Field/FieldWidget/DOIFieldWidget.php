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
 *   id = "doi_field_widget",
 *   module = "persistent_fields",
 *   label = @Translation("DOI Persistent ID Widget"),
 *   field_types = {
 *     "persistent_fields_doi_item"
 *   }
 * )
 */
class DOIFieldWidget extends AbstractFieldWidget
{
  public function getFieldLabelPrefix(): string
  {
    return "DOI ";
  }

  public function onMint($entity): string
  {
    return  \Drupal::service('doi_datacite.minter.datacitedois')->mintDraft($entity);
  }

  public function formElementxcvxcv(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
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
      '#title' => $this->t('Generate'),
      '#type' => 'checkbox',
      '#default_value' => isset($items[$delta]->persistent_item) ? TRUE : FALSE,
      '#ajax' => [
        // 'callback' =>  '\Drupal\persistent_fields\Plugin\Field\FieldWidget\SampleDefaultWidget::myAjaxCallback',
        'callback' => [$this, 'myAjaxCallback'],
        'wrapper' => "persistent-data-wrapper-$random"
      ],
      '#attributes' => [
        "disabled" => isset($items[$delta]->persistent_item) ? TRUE : FALSE,
      ]

    );

    $res = \Drupal::service('doi_datacite.minter.datacitedois')->getDoi("sdf");
    $element['data.id'] = array(
      '#title' => $this->t('data.id'),
      '#type' => 'textfield',
      // '#value' => "EFGH", //$res // ["data"]["id"]
      '#ajax' => [
        // 'callback' =>  '\Drupal\persistent_fields\Plugin\Field\FieldWidget\SampleDefaultWidget::myAjaxCallback',
        'callback' => [$this, 'onFetchDoi'],
        'event' => 'click'
      ],
    );


    return $element;

  }

  public function onFetchDoi() {
    return \Drupal::service('doi_datacite.minter.datacitedois')->getDoi("sdf");
  }

}
