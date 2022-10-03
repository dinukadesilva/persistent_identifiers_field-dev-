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
      '#title' => $this->t('Show root DOI field'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('showRoot')
    ];

    $form['showParent'] = [
      '#title' => $this->t('Show parent DOI field '),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('showParent')
    ];

    return $form;
  }

  public function viewElements(FieldItemListInterface $items, $langcode)
  {
    $elements = [];

    foreach ($items as $delta => $item) {
      $values = $item->getValue();
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => $this->t('<dl>
            ' . ($this->getSetting('showRoot') ? '<dt>Root</dt><dd>@root</dd>' : '') . '
            ' . ($this->getSetting('showParent') ? '<dt>Parent</dt><dd>@parent</dd>' : '') . '
            <dt>DOI</dt><dd>@id</dd>
          </dl>',
          [
            '@root' => $values['persistent_item_root'],
            '@parent' => $values['persistent_item_parent'],
            '@id' => $values['persistent_item']
          ]
        ),
      ];
    }

    return $elements;
  }
}
