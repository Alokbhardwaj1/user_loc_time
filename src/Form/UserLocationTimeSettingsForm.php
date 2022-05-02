<?php

namespace Drupal\user_loc_time\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserLocationTimeSettingsForm. The config form for the User Location & Time Settings module.
 *
 * @package Drupal\user_loc_time\Form
 */
class UserLocationTimeSettingsForm extends ConfigFormBase {

  /**
   * UserLocationTimeSettingsForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory for the form.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
    );
  }

  /**
   * {@inheritDoc}
   */
  protected function getEditableConfigNames() {
    return [
      'user_loc_time.settings',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'user_loc_time_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('user_loc_time.settings');
    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#description' => $this->t('Put the country name here.'),
      '#default_value' => $config->get('country'),
      '#required' => TRUE,
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#description' => $this->t('Put the city name here.'),
      '#default_value' => $config->get('city'),
      '#required' => TRUE,
    ];

    $timezone_lists = [
      "America/Chicago",
      "America/New_York",
      "Asia/Tokyo",
      "Asia/Dubai",
      "Asia/Kolkata",
      "Europe/Amsterdam",
      "Europe/Oslo",
      "Europe/London",
    ];

    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#description' => $this->t('Select your Timezone here'),
      '#default_value' => $config->get('timezone'),
      '#options' => array_combine($timezone_lists, $timezone_lists),
      '#empty_option' => $this->t('Select'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('user_loc_time.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
