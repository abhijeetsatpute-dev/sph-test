<?php

namespace Drupal\ws_qr_code\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\ws_qr_code\Services\QrCode;
use Drupal\Core\Cache\Cache;

/**
 * Provides an Qr block.
 *
 * @Block(
 *   id = "ws_qr_block",
 *   admin_label = @Translation("Qr Block"),
 *   category = @Translation("ws_qr_code"),
 *   context_definitions = {
 *     "node" = @ContextDefinition("entity:node", label = @Translation("Node"), required = TRUE),
 *   }
 * )
 */
class QrBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Qr code service.
   *
   * @var \Drupal\ws_qr_code\Services\QrCode
   */
  protected $qrGenerator;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('ws_qr_code.qr_generator')
    );
  }

  /**
   * Construct the Qr code Service object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\ws_qr_code\Services\QrCode $qr_generator
   *   The Qr Code service.
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition, QrCode $qr_generator) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->qrGenerator = $qr_generator;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    if ($node = $this->getContextValue('node')) {
      $url = $node->get('field_app_purchase_link')->isEmpty() ? NULL : $node->field_app_purchase_link->uri;
      $build = [
        '#theme' => 'qr_code_block',
        '#qr_data' => $this->qrGenerator->getQrCode($url),
        '#app_link' => $url,
        '#app_link_node' => $node->id(),
      ];
    }
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    if ($node = $this->getContextValue('node')) {
      // If there is node add its cachetag.
      return Cache::mergeTags(parent::getCacheTags(), ["node:{$node->id()}"]);
    }
    else {
      // Return default tags instead.
      return parent::getCacheTags();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['route']);
  }

}
