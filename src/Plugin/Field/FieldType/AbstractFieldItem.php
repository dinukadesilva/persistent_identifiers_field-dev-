<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;


class AbstractFieldItem extends FieldItemBase {
    /**
    * {@inheritdoc}
    */
    public static function schema(FieldStorageDefinitionInterface $field) {

      $columns = [
        'persistent_item' => [
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
      if ($this->persistent_item !== NULL && $this->persistent_item !== '') {
        return FALSE;
      }
      return TRUE;
    }


    /**
    * {@inheritdoc}
    */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties['persistent_item'] = DataDefinition::create('string')
        ->setLabel(t('Persistent Field Minted Id'));


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
