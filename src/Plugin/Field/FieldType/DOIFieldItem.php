<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'persistent_fields_doi_field' field type.
 *
 * @FieldType(
 *   id = "persistent_fields_doi_field",
 *   module = "persistent_fields",
 *   label = @Translation("Persistent Identifiers DOI Field"),
 *   category = @Translation("General"),
 *   description = @Translation("DOI minter field and persister."),
 *   default_widget = "doi_field_widget",
 *   default_formatter = "doi_field_formatter",
 *   cardinality = 1
 * )
 *
 * @DCG
 * If you are implementing a single value field type you may want to inherit
 * this class form some of the field type classes provided by Drupal core.
 * Check out /core/lib/Drupal/Core/Field/Plugin/Field/FieldType directory for a
 * list of available field type implementations.
 */
class DOIFieldItem extends AbstractFieldItem
{
  public static function schema(FieldStorageDefinitionInterface $field)
  {
    $schema = parent::schema($field);

    $schema['columns']['persistent_item_root'] = [
      'type' => 'varchar',
      'length' => 1024,
    ];
    $schema['columns']['persistent_item_parent'] = [
      'type' => 'varchar',
      'length' => 1024,
    ];

    return $schema;
  }

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition)
  {
    $properties['persistent_item_root'] = DataDefinition::create('string')
      ->setLabel(t('Persistent Field DOI Root Id'));
    $properties['persistent_item_parent'] = DataDefinition::create('string')
      ->setLabel(t('Persistent Field DOI Parent Id'));
    $properties['persistent_item'] = DataDefinition::create('string')
      ->setLabel(t('Persistent Field DOI Minted Id'));

    return $properties;
  }
}
