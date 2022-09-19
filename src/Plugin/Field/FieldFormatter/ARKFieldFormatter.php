<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ark_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "ark_field_formatter",
 *   module = "persistent_fields",
 *   label = @Translation("ARK Persistent ID field formatter"),
 *   field_types = {
 *     "persistent_fields_ark_field"
 *   }
 * )
 */
class ARKFieldFormatter extends AbstractFieldFormatter
{
  public function getMinterName(): string
  {
    return "ARK";
  }
}
