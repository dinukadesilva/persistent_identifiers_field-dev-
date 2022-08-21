<?php
/**
 * @file
 * Contains \Drupal\persistent_fields\Plugin\Field\Formatter\SampleFieldFormatter.
 */
namespace Drupal\persistent_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'sample_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "sample_field_formatter",
 *   module = "persistent_fields",
 *   label = @Translation("Sample PID field formatter"),
 *   field_types = {
 *     "persistent_fields_sample_item"
 *   }
 * )
 */
class SampleFieldFormatter extends FormatterBase {


    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() {
        return [
        // Declare a setting named 'text_length', with
        // a default value of 'short'
        'sample_item' => 'long',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function settingsForm(array $form, FormStateInterface $form_state) {
        $form['sample_item'] = [
        '#title' => $this->t('Sample Minter'),
        '#type' => 'select',
        '#options' => [
            'short' => $this->t('Short'),
            'long' => $this->t('Long'),
        ],
        '#default_value' => $this->getSetting('sample_item'),
        ];
        
        return $form;
    }



    /**
    * {@inheritdoc}
    */
    public function viewElements(FieldItemListInterface $items, $langcode){
        $elements = [];

        foreach ($items as $delta => $item) {
          $elements[$delta] = [
            // We create a render array to produce the desired markup,
            // "<p style="color: #hexcolor">The color code ... #hexcolor</p>".
            // See theme_html_tag().
            '#type' => 'html_tag',
            '#tag' => 'p',
            '#value' => $this->t('The Minted Identifier for the field is @code', ['@code' => $item->sample_item]),
          ];
        }
    
        return $elements;
        
          
        
  }

 }