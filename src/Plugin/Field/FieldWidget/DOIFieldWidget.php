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
 *     "persistent_fields_doi_field"
 *   }
 * )
 */
class DOIFieldWidget extends AbstractFieldWidget
{
  public function getFieldLabelPrefix(): string
  {
    return 'DOI ';
  }

  public function getProvisionCallback()
  {
    return "persistent_fields_ajax_doi_mint";
  }

  public function validate($element, FormStateInterface $form_state)
  {
    $value = $element['#value'];
    if (strlen($value) === 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
  }

}
