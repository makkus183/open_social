<?php

namespace Drupal\social_views_infinite_scroll;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class SocialInfiniteScrollManager.
 */
class SocialInfiniteScrollManager implements SocialInfiniteScrollManagerInterface {

  /**
   * The config factory interface.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new SocialInfiniteScrollManager object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory interface.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public function getAllAvailableViews() {
    return $this->configFactory->getEditable('social_views_infinite_scroll.settings')->getOriginal();
  }

  /**
   * {@inheritdoc}
   */
  public function getEnabledViews() {
    $all_views = $this->getAllAvailableViews();
    $enabled_views = [];

    foreach ($all_views as $key => $status) {
      if ($status) {
        $enabled_views[$key] = $status;
      }
    }

    return $enabled_views;
  }

  /**
   * {@inheritdoc}
   */
  public function getBlockedViews() {
    return [
      // Some system or distro views.
      'views.view.who_voted_this_entity',
      'views.view.who_liked_this_entity',
      'views.view.watchdog',
      'views.view.user_admin_people',
      'views.view.report_overview',
      'views.view.redirect',
      'views.view.recipient_group_reference',
      'views.view.inbox',
      'views.view.featured_profile_reference',
      'views.view.featured_group_reference',
      'views.view.featured_content_reference',
      'views.view.event_manage_enrollments',
      'views.view.event_enrollments',
      'views.view.content',
      'views.view.community_activities',
      'views.view.comment',
      'views.view.activity_stream_profile',
      'views.view.activity_stream_notifications',
      'views.view.activity_stream_group',
      'views.view.activity_stream',
      // Temporarily here because ajax does not work correctly with these views,
      // probably because of we have a lot config overrides for these views.
      'views.view.search_all',
      'views.view.search_all_autocomplete',
      'views.view.search_content',
      'views.view.search_groups',
      'views.view.search_users',
      // Replace the results to no result.
      'views.view.events',
    ];
  }

}
