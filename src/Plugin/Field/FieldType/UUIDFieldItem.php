<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'persistent_fields_uuid_field' field type.
 *
 * @FieldType(
 *   id = "persistent_fields_uuid_field",
 *   module = "persistent_fields",
 *   label = @Translation("Persistent Identifiers UUID Field"),
 *   category = @Translation("General"),
 *   description = @Translation("UUID minter field and persister."),
 *   default_widget = "uuid_field_widget",
 *   default_formatter = "uuid_field_formatter",
 *   cardinality = 1
 * )
 */
class UUIDFieldItem extends AbstractFieldItem {
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['field_item'] = DataDefinition::create('string')
      ->setLabel(t('Persistent Field UUID Minted Id'));

    return $properties;
  }
}
