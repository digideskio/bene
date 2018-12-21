<?php

namespace Drupal\bene_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\mailchimp_signup\Form\MailchimpSignupPageForm;

/**
 * Provides a 'NewsletterSignupBlock' block.
 *
 * @Block(
 *  id = "bene_newsletter_signup_block",
 *  admin_label = @Translation("Bene Newsletter Signup"),
 *  category = @Translation("Bene")
 * )
 */
class NewsletterSignupBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label_display' => '0',
      'style' => 'external',
      'title' => 'Sign up for our Newsletter',
      'signup_text' => 'Receive updates about what we are doing',
      'external_link' => 'https://mailchimp.com',
      'external_link_label' => '',
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['style'] = [
      '#type' => 'radios',
      '#title' => $this->t('Style'),
      '#default_value' => $this->configuration['style'],
      '#options' => [
        'disabled'  => $this->t('Disabled'),
        'external'  => $this->t('External'),
        'embedded'  => $this->t('MailChimp Form'),
        'salsa_embed' => $this->t('Salsa Embed'),
      ],
    ];
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->configuration['title'],
      '#description' => $this->t('Optional, leave blank to use the link label as the only text.'),
    ];
    $form['signup_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Signup text'),
      '#default_value' => $this->configuration['signup_text'],
      '#description' => $this->t('Optional, leave blank to use the link label as the only text.'),
    ];
    $form['external_link_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('External link settings'),
      '#states' => [
        'visible' => [
          ':input[name="settings[style]"]' => ['value' => 'external'],
        ],
      ],
    ];
    $form['external_link_settings']['external_link'] = [
      '#type' => 'url',
      '#title' => $this->t('Link'),
      '#default_value' => $this->configuration['external_link'],
      '#required' => TRUE,
    ];
    $form['external_link_settings']['external_link_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link label'),
      '#default_value' => $this->configuration['external_link_label'],
      '#required' => TRUE,
    ];

    $form['mailchimp_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('MailChimp settings'),
      '#states' => [
        'visible' => [
          ':input[name="settings[style]"]' => ['value' => 'embedded'],
        ],
      ],
    ];

    // Help the user turn on MailChimp.
    $moduleHandler = \Drupal::service('module_handler');
    if (!$moduleHandler->moduleExists('mailchimp') || !$moduleHandler->moduleExists('mailchimp_signup')) {
      $form['mailchimp_settings']['help_text'] = [
        '#type' => 'markup',
        '#markup' => 'Please <a href="/admin/modules?destination=/admin/structure/block/manage/benenewslettersignup">enable and configure MailChimp and a MailChimp Signup block</a> to begin.',
        '#prefix' => '<p>',
        '#suffix' => '</p>',
      ];
    }
    else {

      // Help the User set a key.
      $mailchimp_config = \Drupal::config('mailchimp.settings');('mailchimp.settings');
      $key = $mailchimp_config->get('api_key');

      if (!$key) {
        $form['mailchimp_settings']['help_text'] = [
          '#type' => 'markup',
          '#markup' => 'Please add a <a href="/admin/config/services/mailchimp?destination=/admin/structure/block/manage/benenewslettersignup">MailChimp API</a> key and create a signup block to begin.',
          '#prefix' => '<p>',
          '#suffix' => '</p>',
        ];
      }
      else {

        // Rely on help text to encourage the user to create a signup block.
        $options = [];
        $signup_blocks = mailchimp_signup_load_multiple();
        $default_signup_block = '';

        foreach ($signup_blocks as $signup_key => $signup) {
          $options[$signup_key] = $signup->title;
          if ($this->configuration['signup_block'] == $signup_key) {
            $default_signup_block = $this->configuration['signup_block'];
          }
        }
        if ($options) {
          $form['mailchimp_settings']['signup_block'] = [
            '#type'          => 'select',
            '#options'       => $options,
            '#title'         => $this->t('Signup Block'),
            '#description'   => $this->t('Select a MailChimp signup block or <a href="/admin/config/services/mailchimp/signup?destination=/admin/structure/block/manage/benenewslettersignup">create a new signup block</a>.'),
            '#default_value' => $default_signup_block,
            '#required'      => FALSE,
            '#states'        => [
              'required' => [
                ':input[name="settings[style]"]' => ['value' => 'embedded'],
              ],
            ],
          ];
        }
        else {
          $form['mailchimp_settings']['signup_block_warning'] = [
            '#type' => 'markup',
            '#markup' => $this->t('To use the MailChimp form style you will need to <a href="/admin/config/services/mailchimp/signup?destination=/admin/structure/block/manage/benenewslettersignup">create a new MailChimp signup block</a> and return to this page to select it.'),
            '#prefix' => '<p>',
            '#suffix' => '</p>',
          ];
        }
      }
    }

    $form['salsa_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Salsa Embed Code'),
      '#default_value' => empty($this->configuration['salsa_code']) ? '' : $this->configuration['salsa_code'],
      '#description' => t('The unique identifier from Salsa for your form. To find this, visit the "Published Details" section of your form and look in "Form Widget Code" for something resembling: <br/> <code>&lt;div id="123456-this-is-your-code123456"&gt;</code><br/>Copy/paste the <code>123456-this-is-your-code123456</code> part here.'),
      '#states' => [
        'visible' => [
          ':input[name="settings[style]"]' => ['value' => 'salsa_embed'],
        ],
        'required' => [
          ':input[name="settings[style]"]' => ['value' => 'salsa_embed'],
        ],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::validateConfigurationForm($form, $form_state);

    switch ($form_state->getValue('style')) {
      case 'embedded':
        $mailchimp_settings = $form_state->getValue('mailchimp_settings');
        if (!$mailchimp_settings['signup_block']) {
          $form_state->setErrorByName('mailchimp_settings', t('A valid MailChimp signup block is required, please create one or choose a different style.'));
        }
        break;

      case 'raw_embed':
        if (empty($form_state->getValue('raw_embed'))) {
          $form_state->setErrorByName('raw_embed', t('Embed code is required to use the "Embedded" style.'));
        }
        break;

    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setValue('form_state', $form_state->getValues());
  }

  /**
   * Helper function to traverse form inputs and set configuration keys.
   */
  private function setValue($label, $value) {
    if (is_array($value)) {
      foreach ($value as $key => $val) {
        $this->setValue($key, $val);
      }
    }
    else {
      $this->configuration[$label] = $value;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $style = $this->configuration['style'];

    if (!empty($style) && $style != 'disabled') {
      $build['signup'] = [
        '#type' => 'container',
        '#weight' => 1,
        '#attributes' => [
          'class' => 'external-newsletter',
        ],
      ];
      if ($this->configuration['title']) {
        $build['signup']['title'] = [
          '#type' => 'markup',
          '#markup' => $this->configuration['title'],
          '#prefix' => '<h2>',
          '#suffix' => '</h2>',
        ];
      }
      if ($this->configuration['signup_text']) {
        $build['signup']['signup_text'] = [
          '#type' => 'markup',
          '#markup' => $this->configuration['signup_text'],
          '#prefix' => '<p>',
          '#suffix' => '</p>',
        ];
      }
    }
    switch ($style) {
      case 'external':
        // External link.
        if ($this->configuration['signup_text'] || $this->configuration['title']) {
          $build['signup']['link'] = [
            '#type' => 'link',
            '#title' => $this->configuration['external_link_label'],
            '#url' => Url::fromUri($this->configuration['external_link']),
            '#attributes' => [
              'class' => 'button',
            ],
          ];
        }
        else {
          $build['signup']['link'] = [
            '#type' => 'link',
            '#title' => $this->configuration['external_link_label'],
            '#url' => Url::fromUri($this->configuration['external_link']),
          ];
        };

        break;

      case 'embedded':
        // Embedded a signup block.
        $moduleHandler = \Drupal::service('module_handler');
        if ($moduleHandler->moduleExists('mailchimp') && $moduleHandler->moduleExists('mailchimp_signup')) {

          $signup_entity = $this->configuration['signup_block'];
          $signup = mailchimp_signup_load($signup_entity);

          if ($signup) {
            $form = new MailchimpSignupPageForm();

            $form_id = 'mailchimp_signup_subscribe_block_' . $signup->id . '_form';
            $form->setFormID($form_id);
            $form->setSignup($signup);

            $build['signup']['form'] = \Drupal::formBuilder()->getForm($form);
          }
        }
        break;

      case 'salsa_embed':
        // Salsa Embed.
        $salsa_code = $this->configuration['salsa_code'];
        $build['signup']['embedded_form'] = [
          '#type' => 'inline_template',
          '#template' => '{{ embed|raw }}',
          '#context' => [
            // Todo: that second chunk of gobbledygook is probably a unique identifier for the org.
            'embed' => "<div id='$salsa_code'><script type='text/javascript' src='https://default.salsalabs.org/api/widget/template/1ed140ec-965b-47c3-8cb3-ae01826fde8a/?tId=$salsa_code' ></script> \</div>",
          ],
        ];

      default:
        // No link.
    }

    return $build;
  }

}
