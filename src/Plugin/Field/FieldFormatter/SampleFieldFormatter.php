<?php
/**
 * @file
 * Contains \Drupal\persistent_fields\Plugin\Field\Formatter\SampleFieldFormatter.
 */
namespace Drupal\persistent_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'sample_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "sample_field_formatter",
 *   module = "persistent_fields",
 *   label = @Translation("Sample PID field formatter"),
 *   field_types = {
 *     "persistent_fields_sample_field"
 *   }
 * )
 */
class SampleFieldFormatter extends AbstractFieldFormatter
{
  public function getMinterName(): string
  {
    return "Sample";
  }
}
