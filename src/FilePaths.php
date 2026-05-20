<?php

namespace Acquia\DrupalEnvironmentDetector;

/**
 * Returns paths for common directories and settings files.
 *
 * @package Acquia\DrupalEnvironmentDetector
 */
class FilePaths {

  /**
   * Path to primary site settings file with db, memcache, and other info.
   *
   * @param string $ah_group
   *   The Acquia Hosting site group.
   * @param string $site_name
   *   The site name (e.g. `default`).
   *
   * @return string
   *   The path to the settings include file.
   */
  public static function ahSettingsFile(string $ah_group, string $site_name) {
    // The default site uses ah_group-settings.inc.
    if ($site_name === 'default') {
      $site_name = $ah_group;
    }

    // Acquia Cloud does not support periods or hyphens in db names.
    $site_name = str_replace(['.', '-'], '_', $site_name);

    return "/var/www/site-php/$ah_group/$site_name-settings.inc";
  }

  /**
   * Path to sites.json on ACSF.
   *
   * This file contains information about all sites on an ACSF subscription.
   *
   * @param string $ah_group
   *   The Acquia Hosting site group.
   * @param string $ah_env
   *   The Acquia Hosting environment.
   *
   * @return string
   *   The path to sites.json.
   */
  public static function acsfSitesJson(string $ah_group, string $ah_env) {
    return "/var/www/site-php/$ah_group.$ah_env/multisite-config.json";
  }

  /**
   * Path to the MEO common settings include file.
   *
   * Acquia MEO environments use a single shared settings include for all sites
   * in the subscription, dynamically loading the correct database credentials.
   *
   * @param string $ah_group
   *   The Acquia Hosting site group (AH_SITE_GROUP).
   *
   * @return string
   *   The path to the MEO settings common include file.
   *
   * @see https://docs.acquia.com/acquia-cloud-platform/add-ons/multi-experience-operations/managing-sitesphp-and-settingsphp
   */
  public static function ahMeoSettingsFile(string $ah_group): string {
    return "/var/www/site-php/$ah_group/$ah_group-settings.common.inc";
  }

  /**
   * The path to the persistent file storage mount.
   *
   * It is used to store Drupal public and private files, but is only a common
   * base path and not tied to any particular site or type of file.
   *
   * @see https://docs.acquia.com/acquia-cloud/manage/files/about/
   */
  public static function ahFilesRoot(string $ah_group, string $ah_env) {
    return '/mnt/files/' . $ah_group . '.' . $ah_env;
  }

}
