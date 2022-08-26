<?php


namespace Drupal\persistent_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Plugin implementation of the 'uuid_field_widget' widget.
 *
 * @FieldWidget(
 *   id = "uuid_field_widget",
 *   module = "persistent_fields",
 *   label = @Translation("UUID Persistent ID Widget"),
 *   field_types = {
 *     "persistent_fields_uuid_item"
 *   }
 * )
 */
class UUIDFieldWidget extends AbstractFieldWidget
{
  public function getFieldLabelPrefix(): string
  {
    return "UUID ";
  }

  public function onMint($entity): string
  {
    return  \Drupal::service('persistent_identifiers.minter.uuid')->mint($entity);
  }

}
