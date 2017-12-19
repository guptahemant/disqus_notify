<?php

namespace Drupal\disqus_notify\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Mail\MailManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Utility\Token;

/**
 * Class NotifyAuthorController.
 */
class NotifyAuthorController extends ControllerBase {

  protected $requestStack;
  protected $mailManager;
  protected $configFactory;
  protected $token;

  /**
   * {@inheritdoc}
   */
  public function __construct(RequestStack $requestStack, MailManager $mailManager, ConfigFactoryInterface $config_factory, Token $token) {
    $this->requestStack = $requestStack;
    $this->mailManager = $mailManager;
    $this->configFactory = $config_factory;
    $this->token = $token;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('plugin.manager.mail'),
      $container->get('config.factory'),
      $container->get('token')
    );
  }

  /**
   * Notifyauthor.
   *
   * @return string
   *   Return Hello string.
   */
  public function notifyAuthor() {
    // Logs a notice
    // $commentId = implode('/',\Drupal::request()->request->keys());
    $commentId = $this->requestStack->getCurrentRequest()->request->get('id');
    $commentText = \Drupal::request()->request->get('text');
    $commentIdentifier = \Drupal::request()->request->get('identifier');
    $message = 'comment posted on disqus test ajax: ' . $commentId . " : " . $commentText . " : " . $commentIdentifier;

    // Load the entity from identifier.
    $identifierData = explode('/', $commentIdentifier);
    $entity_type = $identifierData[0];
    $entity = entity_load($entity_type, $identifierData[1]);

    // Get the form settings.
    $config = $this->configFactory->get('disqus_notify.disqusnotifysettings');

    // Start creating the email.
    $mailManager = $this->mailManager;
    $module = 'disqus_notify';
    $key = 'disqus_notify';
    $to = $entity->getOwner()->getEmail();
    $emailMessage = $config->get('email_message');
    $emailMessage = $this->token->replace($emailMessage,
      [$entity_type => $entity],
      ['clear' => TRUE]
    );
    $params['subject'] = $config->get('subject');
    $params['message'] = $emailMessage;
    $langcode = $entity->getOwner()->getPreferredLangcode();
    $send = TRUE;
    $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
    if ($result['result'] !== TRUE) {
      \Drupal::logger('disqus_notify')->notice("email error");
    }
    else {
      \Drupal::logger('disqus_notify')->notice($emailMessage);
    }
    \Drupal::logger('disqus_notify')->notice($message);
    $r['html'] = $message;
    return new JsonResponse($r);
  }

}
