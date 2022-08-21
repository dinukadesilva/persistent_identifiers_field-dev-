<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'persistent_fields_sample_item' field type.
 *
 * @FieldType(
 *   id = "persistent_fields_sample_item",
 *   module = "persistent_fields",
 *   label = @Translation("Persistent Identifiers Sample Field"),
 *   category = @Translation("General"),
 *   description = @Translation("Sample minter field and persister."),
 *   default_widget = "sample_field_widget",
 *   default_formatter = "sample_field_formatter"
 * )
 */
class SampleFieldItem extends AbstractFieldItem {
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['field_item'] = DataDefinition::create('string')
      ->setLabel(t('Persistent Field Sample Minted Id'));

    return $properties;
  }
}
