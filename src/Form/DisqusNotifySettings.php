<?php

namespace Drupal\disqus_notify\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DisqusNotifySettings.
 */
class DisqusNotifySettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'disqus_notify.disqusnotifysettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'disqus_notify_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('disqus_notify.disqusnotifysettings');
    $form['enable_notifications'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable notifications'),
      '#description' => $this->t('Check this box if you want to send email notifications to the authors of entity.You may need to clear the cache to see the results.'),
      '#default_value' => $config->get('enable_notifications'),
    ];
    $form['subject'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Subject'),
      '#description' => $this->t('Enter the subject to send in email.'),
      '#default_value' => $config->get('subject'),
    ];
    $form['email_message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Email message'),
      '#description' => $this->t('Enter the email message to send to the content author.This field support tokens'),
      '#default_value' => $config->get('email_message'),
    ];
    if (\Drupal::moduleHandler()->moduleExists('token')) {
      $form['token_help'] = [
        '#type' => 'markup',
        '#token_types' => ['node'],
        '#theme' => 'token_tree_link',
      ];
    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('disqus_notify.disqusnotifysettings')
      ->set('enable_notifications', $form_state->getValue('enable_notifications'))
      ->set('subject', $form_state->getValue('subject'))
      ->set('email_message', $form_state->getValue('email_message'))
      ->save();
  }

}
