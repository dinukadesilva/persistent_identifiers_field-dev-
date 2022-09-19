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
 *   id = "ark_field_widget",
 *   module = "persistent_fields",
 *   label = @Translation("ARK Persistent ID Widget"),
 *   field_types = {
 *     "persistent_fields_ark_field"
 *   }
 * )
 */
class ARKFieldWidget extends AbstractFieldWidget
{
  public function getFieldLabelPrefix(): string
  {
    return "ARK ";
  }

  public function onMint($entity): string
  {
    return  \Drupal::service('ezid.minter.ezid')->mint($entity);
  }

}
