<?php

namespace Drupal\social_event_invite\Routing;

use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class InvitesOverviewSubscriber.
 *
 * @package Drupal\social_event\Routing
 */
class InvitesOverviewSubscriber implements EventSubscriberInterface {

  /**
   * Get the request events.
   *
   * @inheritDoc
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['checkAccessToEnrollInvitesOverview'];
    return $events;
  }

  /**
   * Check if the user is allowed to view this overview.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The event.
   */
  public function checkAccessToEnrollInvitesOverview(GetResponseEvent $event) {
    $current_route = \Drupal::routeMatch()->getRouteName();
    // First, lets check if the route matches.
    if ($current_route === 'view.event_manage_enrollment_invites.page_manage_enrollment_invites') {
      // Now lets get some stuff we need to perform some checks on.
      $current_event = social_event_get_current_event();
      // Now, lets check:
      // - If the current user has a permission to see the overview.
      // - If the current user is the owner/creator of this event.
      // - If the current user is an organiser/manager of this event.
      // And then allow access.
      if (social_event_owner_or_organizer()) {
        return;
      }

      // We deny the rest and send them to the front page.
      $event->setResponse(new RedirectResponse(Url::fromRoute('entity.node.canonical', ['node' => $current_event->id()])->toString()));
    }
  }

}