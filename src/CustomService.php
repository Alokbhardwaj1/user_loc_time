<?php

namespace Drupal\user_loc_time;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Render\RendererInterface;

/**
 * Defines a class to build current date time on timezone basis.
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
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * CustomService constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, RendererInterface $renderer) {
    $this->configFactory = $config_factory;
    $this->renderer = $renderer;
  }

  /**
   * Gets the current date time on timezone basis.
   *
   * @return \Drupal\Component\Render\MarkupInterface
   *   The formatted current date time.
   */
  public function currentTime() {
    $config = $this->configFactory->get('user_loc_time.settings');
    $timezone = $config->get('timezone');
    $date = new \DateTime("now", new \DateTimeZone($timezone));
    $build = [
      '#markup' => $date->format('dS M Y - g:i A'),
    ];
    $this->renderer->addCacheableDependency($build, $config);
    return $build;
  }

}
