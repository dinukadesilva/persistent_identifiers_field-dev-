<?php

namespace Drupal\persistent_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

class AbstractFieldFormatter extends FormatterBase
{

  public function getMinterName(): string
  {
    return '';
  }


  /**
   * {@inheritdoc}
   */
  public static function defaultSettings()
  {
    return [
      'persistent_item' => 'long',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state)
  {
    $form['sample_item'] = [
      '#title' => $this->t($this->getMinterName() . ' Minter'),
      '#type' => 'select',
      '#options' => [
        'short' => $this->t('Short'),
        'long' => $this->t('Long'),
      ],
      '#default_value' => $this->getSetting('persistent_item'),
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode)
  {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        // We create a render array to produce the desired markup,
        // "<p style="color: #hexcolor">The color code ... #hexcolor</p>".
        // See theme_html_tag().
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => $this->t('The Minted Identifier for the field is @code', ['@code' => $item->persistent_item]),
      ];
    }

    return $elements;


  }

}
