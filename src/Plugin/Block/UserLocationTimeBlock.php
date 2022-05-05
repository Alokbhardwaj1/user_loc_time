<?php

namespace Drupal\user_loc_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user_loc_time\CustomService;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "user_location_time_block",
 *   admin_label = @Translation("User Location & Time Block"),
 * )
 */
class UserLocationTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The config factory.
   *
   * @var \Drupal\user_loc_time\CustomService
   */
  protected $customService;

  /**
   * UserLocationTimeBlock constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory.
   * @param \Drupal\user_loc_time\CustomService $customService
   *   The custom service for render current datetime.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory, CustomService $customService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $configFactory;
    $this->customService = $customService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('user_loc_time.custom_services')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('user_loc_time.settings');
    $country = $config->get('country');
    $city = $config->get('city');
    $current_time = $this->customService->currentTime();
    return [
      '#theme' => 'user_location_time',
      '#country' => $country,
      '#city' => $city,
      '#current_time' => $current_time,
    ];
  }

}
