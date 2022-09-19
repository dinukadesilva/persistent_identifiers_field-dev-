<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'doi_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "doi_field_formatter",
 *   module = "persistent_fields",
 *   label = @Translation("DOI Persistent ID field formatter"),
 *   field_types = {
 *     "persistent_fields_doi_field"
 *   }
 * )
 */
class DOIFieldFormatter extends AbstractFieldFormatter
{
  public function getMinterName(): string
  {
    return "DOI";
  }
}
