<?php

namespace Drupal\bene_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

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
      'style' => '1',
      'title' => 'Sign up for our Newsletter',
      'signup_text' => 'Receive updates about what we are doing',
      'external_link' => '',
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
        0 => $this->t('Disabled'),
        1 => $this->t('External'),
        2 => $this->t('Embedded Form'),
      ],
    ];
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->configuration['title'],
    ];
    $form['signup_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Signup text'),
      '#default_value' => $this->configuration['signup_text'],
    ];
    // TODO: Show fieldset only when style = 1.
    $form['external_link_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('External link settings'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    ];
    $form['external_link_settings']['external_link'] = [
      '#type' => 'url',
      '#title' => $this->t('Link'),
      '#default_value' => $this->configuration['external_link'],
    ];
    $form['external_link_settings']['external_link_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link label'),
      '#default_value' => $this->configuration['external_link_label'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['style'] = $form_state->getValue('style');
    $this->configuration['title'] = $form_state->getValue('title');
    $this->configuration['signup_text'] = $form_state->getValue('signup_text');

    $external_link_settings = $form_state->getValue('external_link_settings');
    $this->configuration['external_link'] = $external_link_settings['external_link'];
    $this->configuration['external_link_label'] = $external_link_settings['external_link_label'];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    switch ($this->configuration['style']) {
      case 1:
        // External link.
        $build['title'] = [
          '#type' => 'markup',
          '#markup' => $this->configuration['title'],
        ];
        $build['signup_text'] = [
          '#type' => 'markup',
          '#markup' => $this->configuration['signup_text'],
        ];
        $build['link'] = [
          '#type' => 'markup',
          '#markup' => '<a href="' . $this->configuration['external_link'] . '">' . $this->configuration['external_link_label'] . '</a>',
        ];
        break;

      case 2:
        // Embedded link.
        // TODO: Define "Embedded" display. On hold per GitHub issue #69.
        $build = [];
        break;

      default:
        // No link.
        $build = [];
    }

    return $build;
  }

}
