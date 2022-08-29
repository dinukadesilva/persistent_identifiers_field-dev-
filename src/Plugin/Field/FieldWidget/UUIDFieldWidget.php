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

  public function validate($element, FormStateInterface $form_state) {
    parent::validate($element, $form_state);

    $value = $element['#value'];
    $persistent_identifier_uuid_regex = "/^http(s?):\/\/.*([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}).*/";
    if (strlen($value) > 0 && !@preg_match($persistent_identifier_uuid_regex, $value)) {
      $form_state->setError($element, $this->t('UUID persistent identifier must be a URL containing a UUID.'));
    }
  }
}
