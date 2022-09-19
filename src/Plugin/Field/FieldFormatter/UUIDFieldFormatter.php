<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'uuid_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "uuid_field_formatter",
 *   module = "persistent_fields",
 *   label = @Translation("UUID Persistent ID field formatter"),
 *   field_types = {
 *     "persistent_fields_uuid_field"
 *   }
 * )
 */
class UUIDFieldFormatter extends AbstractFieldFormatter
{
  public function getMinterName(): string
  {
    return "UUID";
  }
}
