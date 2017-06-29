<?php

namespace Drupal\d8_example\Controller;

use Drupal\Core\Controller\ControllerBase;

class BasicController extends ControllerBase {

  /**
   * Display markup.
   *
   * @return array
   */
  public function content() {

    return [
      '#markup' => t('Hey there!'),
    ];
  }
}
