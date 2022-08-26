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
 *   label = @Translation("Sample Persistent ID Widget"),
 *   field_types = {
 *     "persistent_fields_sample_item"
 *   }
 * )
 */
class SampleFieldWidget extends AbstractFieldWidget
{
  public function getFieldLabelPrefix(): string
  {
    return "Sample ";
  }

  public function onMint($entity): string
  {
    return  \Drupal::service('sample_minter.minter.sample')->mint($entity);
  }

}
