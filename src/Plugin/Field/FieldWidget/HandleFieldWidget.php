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
 *   id = "handle_field_widget",
 *   module = "persistent_fields",
 *   label = @Translation("Handle Persistent ID Widget"),
 *   field_types = {
 *     "persistent_fields_handle_field"
 *   }
 * )
 */
class HandleFieldWidget extends AbstractFieldWidget
{
  public function getFieldLabelPrefix(): string
  {
    return "Handle ";
  }

  public function onMint($entity): string
  {
    return  \Drupal::service('hdl.minter.hdl')->mint($entity);
  }

}
