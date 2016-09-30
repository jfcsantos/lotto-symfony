<?php

namespace AppBundle\EventListener;

use AppBundle\Controller\DefaultController;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationListener implements EventSubscriberInterface
{
  private $router;

  public function __construct(UrlGeneratorInterface $router)
  {
    $this->router = $router;
  }

  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents()
  {
    return array(
      FOSUserEvents::REGISTRATION_SUCCESS => array('onFormSuccess',-10),
    );
  }

  public function onFormSuccess(FormEvent $event)
  {
    $url = $this->router->generate('lottery_index');

    $request = $event->getRequest();
    $referer = $request->headers->get('referer');
    $refererQuery = explode('?',$referer);

    if(isset($refererQuery[1])) {
      parse_str($refererQuery[1], $output);
      if(isset($output['ref_path']) && $output['ref_path'] != '') {
        $url = $output['ref_path'];
      }
    }
    $event->setResponse(new RedirectResponse($url));
  }

}
