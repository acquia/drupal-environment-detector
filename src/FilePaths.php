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

    // Acquia Cloud does not support periods in db names.
    $site_name = str_replace('.', '_', $site_name);

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
    return "/mnt/files/$ah_group.$ah_env/files-private/sites.json";
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
