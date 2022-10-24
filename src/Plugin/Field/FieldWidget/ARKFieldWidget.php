<?php


namespace Drupal\persistent_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Plugin implementation of the 'sample_field_widget' widget.
 *
 * @FieldWidget(
 *   id = "ark_field_widget",
 *   module = "persistent_fields",
 *   label = @Translation("ARK Persistent ID Widget"),
 *   field_types = {
 *     "persistent_fields_ark_field"
 *   }
 * )
 */
class ARKFieldWidget extends AbstractFieldWidget
{
  public function getFieldLabelPrefix(): string
  {
    return "ARK ";
  }

  public function getProvisionCallback()
  {
    return "persistent_fields_ajax_ark_mint";
  }

  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
  {
    $element = parent::formElement($items, $delta, $element, $form, $form_state); // TODO: Change the autogenerated stub

    $disabled = False;
    if (isset($element['persistent_item']) && isset($element['persistent_item']['#attributes'])) {
      $disabled = $element['persistent_item']['#attributes']['disabled'];
    }

    $element['persistent_item_root'] = array(
      '#title' => $this->t('Root ARK'),
      '#type' => $this->getSetting('showRoot') ? 'textfield' : 'hidden',
      '#default_value' => isset($items[$delta]->persistent_item_root) ? $items[$delta]->persistent_item_root : NULL,
      "#attributes" => [
        "disabled" => $disabled
      ]
    );
    $element['persistent_item_parent'] = array(
      '#title' => $this->t('Parent ARK'),
      '#type' => $this->getSetting('showParent') ? 'textfield' : 'hidden',
      '#default_value' => isset($items[$delta]->persistent_item_parent) ? $items[$delta]->persistent_item_parent : NULL,
      "#attributes" => [
        "disabled" => $disabled
      ]
    );

    return $element;
  }

  public static function defaultSettings()
  {
    return array_merge(
      [
        'showRoot' => FALSE,
        'showParent' => FALSE,
      ],
      parent::defaultSettings());
  }

  public function settingsSummary()
  {
    $summary = [];

    if ($this->getSetting('showRoot')) {
      $summary[] = 'Show: root ';
    } else {
      $summary[] = 'Hide: root ';
    }

    if ($this->getSetting('showParent')) {
      $summary[] = 'Show: parent ';
    } else {
      $summary[] = 'Hide: parent ';
    }

    return $summary;
  }

  public function settingsForm(array $form, FormStateInterface $form_state)
  {
    $form['showRoot'] = [
      '#title' => $this->t('Show root ARK field'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('showRoot')
    ];

    $form['showParent'] = [
      '#title' => $this->t('Show parent ARK field '),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('showParent')
    ];

    return $form;
  }


}
