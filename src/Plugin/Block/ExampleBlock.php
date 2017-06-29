<?php

namespace Drupal\d8_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an 'Example' Block.
 *
 * @Block(
 *   id = "example_block",
 *   admin_label = @Translation("D8 Example block"),
 * )
 */
class ExampleBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'generate example content');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['hello_name'])) {
      $name = $config['hello_name'];
    }
    else {
      $name = $this->t('to no one');
    }
    return [
      '#theme' => 'example_block',
      '#message' => $this->t('Hello @name!', [
        '@name' => $name
      ])
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['example_block_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => isset($config['hello_name']) ? $config['hello_name'] : '',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['hello_name'] = $form_state->getValue('example_block_name');
  }
}
