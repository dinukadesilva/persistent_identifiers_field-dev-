<?php


namespace Drupal\persistent_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;

const DOI_RESOURCE_TYPE = [
  'Book', 'BookChapter', 'Collection', 'ComputationalNotebook', 'ConferencePaper', 'ConferenceProceeding',
  'DataPaper', 'Dataset', 'Dissertation', 'Event', 'Image', 'InteractiveResource', 'Journal', 'JournalArticle',
  'Model', 'OutputManagementPlan', 'PeerReview', 'PhysicalObject', 'Preprint', 'Report', 'Service', 'Software',
  'Sound', 'Standard', 'Text', 'Workflow', 'Other'
];

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
    return '';
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
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
  {
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
        "id" => "persistent_item-$random",
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
        'callback' => 'persistent_fields_ajax_doi_mint',
        'wrapper' => $element['#attributes']['id'], //"persistent-data-wrapper-$random",
        'event' => 'change'
      ],
      '#attributes' => [
        "disabled" => isset($items[$delta]->persistent_item) ? TRUE : FALSE,
      ]
    );

    return $element;
  }
}
