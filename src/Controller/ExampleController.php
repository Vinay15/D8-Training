<?php

namespace Drupal\d8_example\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExampleController extends ControllerBase {

  /**
   * @var ConfigFactoryInterface
   */
  protected $exampleconfig;

  /**
   * ExampleController constructor.
   *
   * @param ConfigFactoryInterface $configFactory
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->exampleconfig = $configFactory;
  }

  /**
   * @inheritdoc
   */
  public static function create(ContainerInterface $container) {
    return new static (
      $container->get('config.factory')
    );
  }

  /**
   * Display the markup.
   *
   * @return array
   */
  public function basic() {

    // Directly printing the text message.
    return [
      '#markup' => $this->t('Hello World!'),
    ];
  }

  /**
   * Print default config message.
   *
   * @return array|mixed|null
   */
  public function directAccess() {

    $message = \Drupal::config('d8_example.settings')->get('d8_example.page_title');

    return [
      '#markup' => $message
    ];
  }

  /**
   * Print default config message using dependency injection method.
   *
   * @return array|mixed|null
   */
  public function usingDependencyInjection() {

    $message = $this->exampleconfig->get('d8_example.settings')->get('d8_example.source_text');

    return [
      '#markup' => $message
    ];
  }

  /**
   * Print message using custom theme funcion via template.
   *
   * @return array
   */
  public function usingTemplate() {

    // Rendering the output using template.
    $message = $this->t('Hello') . ' ' . $this->exampleconfig->get('d8_example.settings')->get('d8_example.name') . '!';

    // Update config.
    $this->exampleconfig->getEditable('d8_example.settings')->set('d8_example.name', 'Vinay')->save();

    return [
      '#theme' => 'example_block',
      '#message' => $message,
    ];
  }
}
