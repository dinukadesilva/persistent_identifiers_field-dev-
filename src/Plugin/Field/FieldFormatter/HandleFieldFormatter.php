<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'handle_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "handle_field_formatter",
 *   module = "persistent_fields",
 *   label = @Translation("Handle Persistent ID field formatter"),
 *   field_types = {
 *     "persistent_fields_handle_item"
 *   }
 * )
 */
class HandleFieldFormatter extends AbstractFieldFormatter
{
  public function getMinterName(): string
  {
    return "Handle";
  }
}
