<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'persistent_fields_handle_field' field type.
 *
 * @FieldType(
 *   id = "persistent_fields_handle_field",
 *   module = "persistent_fields",
 *   label = @Translation("Persistent Identifiers Handle Field"),
 *   category = @Translation("General"),
 *   description = @Translation("Handle minter field and persister."),
 *   default_widget = "handle_field_widget",
 *   default_formatter = "handle_field_formatter"
 * )
 *
 * @DCG
 * If you are implementing a single value field type you may want to inherit
 * this class form some of the field type classes provided by Drupal core.
 * Check out /core/lib/Drupal/Core/Field/Plugin/Field/FieldType directory for a
 * list of available field type implementations.
 */
class HandleFieldItem extends AbstractFieldItem {
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['field_item'] = DataDefinition::create('string')
      ->setLabel(t('Persistent Field Handle Minted Id'));

    return $properties;
  }
}
