<?php

namespace Drupal\bene_social\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'SocialBlock' block.
 *
 * @Block(
 *  id = "social_block",
 *  admin_label = @Translation("Social Media Links"),
 * )
 */
class SocialBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label_display' => '0',
      'facebook' => '',
      'google' => '',
      'instagram' => '',
      'linkedin' => '',
      'pinterest' => '',
      'tumblr' => '',
      'twitter' => '',
      'youtube' => '',
    ] + parent::defaultConfiguration();

  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['facebook'] = [
      '#type' => 'url',
      '#title' => $this->t('Facebook'),
      '#description' => '',
      '#default_value' => $this->configuration['facebook'],
      '#weight' => '10',
    ];
    $form['google'] = [
      '#type' => 'url',
      '#title' => $this->t('Google+'),
      '#description' => '',
      '#default_value' => $this->configuration['google'],
      '#weight' => '11',
    ];
    $form['instagram'] = [
      '#type' => 'url',
      '#title' => $this->t('Instagram'),
      '#description' => '',
      '#default_value' => $this->configuration['instagram'],
      '#weight' => '12',
    ];
    $form['linkedin'] = [
      '#type' => 'url',
      '#title' => $this->t('LinkedIn'),
      '#description' => '',
      '#default_value' => $this->configuration['linkedin'],
      '#weight' => '13',
    ];
    $form['pinterest'] = [
      '#type' => 'url',
      '#title' => $this->t('Pinterest'),
      '#description' => '',
      '#default_value' => $this->configuration['pinterest'],
      '#weight' => '14',
    ];
    $form['tumblr'] = [
      '#type' => 'url',
      '#title' => $this->t('Tumblr'),
      '#description' => '',
      '#default_value' => $this->configuration['tumblr'],
      '#weight' => '15',
    ];
    $form['twitter'] = [
      '#type' => 'url',
      '#title' => $this->t('Twitter'),
      '#description' => '',
      '#default_value' => $this->configuration['twitter'],
      '#weight' => '16',
    ];
    $form['youtube'] = [
      '#type' => 'url',
      '#title' => $this->t('YouTube'),
      '#description' => '',
      '#default_value' => $this->configuration['youtube'],
      '#weight' => '17',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['text_format'] = $form_state->getValue('text_format');
    $this->configuration['facebook'] = $form_state->getValue('facebook');
    $this->configuration['flickr'] = $form_state->getValue('flickr');
    $this->configuration['google'] = $form_state->getValue('google');
    $this->configuration['instagram'] = $form_state->getValue('instagram');
    $this->configuration['linkedin'] = $form_state->getValue('linkedin');
    $this->configuration['pinterest'] = $form_state->getValue('pinterest');
    $this->configuration['tumblr'] = $form_state->getValue('tumblr');
    $this->configuration['twitter'] = $form_state->getValue('twitter');
    $this->configuration['youtube'] = $form_state->getValue('youtube');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#prefix'] = '<style>.bene-social-links {background: #cccccc;}</style><div class="bene-social-links">';
    $build['social_block_facebook']['#markup'] = '<p>' . $this->configuration['facebook'] . '</p>';
    $build['social_block_flickr']['#markup'] = '<p>' . $this->configuration['flickr'] . '</p>';
    $build['social_block_google']['#markup'] = '<p>' . $this->configuration['google'] . '</p>';
    $build['social_block_instagram']['#markup'] = '<p>' . $this->configuration['instagram'] . '</p>';
    $build['social_block_linkedin']['#markup'] = '<p>' . $this->configuration['linkedin'] . '</p>';
    $build['social_block_pinterest']['#markup'] = '<p>' . $this->configuration['pinterest'] . '</p>';
    $build['social_block_tumblr']['#markup'] = '<p>' . $this->configuration['tumblr'] . '</p>';
    $build['social_block_twitter']['#markup'] = '<p>' . $this->configuration['twitter'] . '</p>';
    $build['social_block_youtube']['#markup'] = '<p>' . $this->configuration['youtube'] . '</p>';
    $build['#suffix'] = '</div>';
    return $build;
  }

}
