<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'persistent_fields_sample_item' field type.
 *
 * @FieldType(
 *   id = "persistent_fields_uuid_item",
 *   module = "persistent_fields",
 *   label = @Translation("Persistent Identifiers UUID Field"),
 *   category = @Translation("General"),
 *   description = @Translation("UUID minter field and persister."),
 *   default_widget = "uuid_field_widget",
 *   default_formatter = "uuid_field_formatter"
 * )
 */
class UUIDFieldItem extends FieldItemBase {
    /**
    * {@inheritdoc}
    */
    public static function schema(FieldStorageDefinitionInterface $field) {

      $columns = [
        'uuid_item' => [
          'type' => 'varchar',
          'length' => 1000,
          
        ],
      ];
      $schema = [
        'columns' => $columns,
        // @DCG Add indexes here if necessary.
      ];
      return $schema;
    }

    /**
    * {@inheritdoc}
    */
    public function isEmpty() {
      if ($this->uuid_item !== NULL && $this->uuid_item !== '') {
        return FALSE;
      }
      return TRUE;
    }
  

    /**
    * {@inheritdoc}
    */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties['uuid_item'] = DataDefinition::create('string')
        ->setLabel(t('Persistent Field UUID Minted Id'));


        return $properties;
    }

  /**
   * {@inheritdoc}
  */
  public function getConstraints() {
    $constraints = parent::getConstraints();
    
    return $constraints;
  }

 }