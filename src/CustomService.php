<?php

namespace Drupal\user_loc_time;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class CustomService.
 *
 * @package Drupal\user_loc_time\Services
 */
class CustomService {

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * CustomService constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * @return \Drupal\Component\Render\MarkupInterface|string
   */
  public function currentTime() {
    $config = $this->configFactory->get('user_loc_time.settings');
    $timezone = $config->get('timezone');
    $date = new \DateTime("now", new \DateTimeZone($timezone));
    return $date->format('dS M Y - g:i A');
  }

}
