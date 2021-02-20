<?php

namespace Acquia\DrupalEnvironmentDetector;

/**
 * Returns paths for common directories and settings files.
 *
 * @package Acquia\DrupalEnvironmentDetector
 */
class FilePaths {

  /**
   * Path to sites.json on ACSF.
   *
   * This file contains information about all sites on an ACSF subscription.
   *
   * @param $ah_group
   *   The Acquia Hosting site group.
   * @param $ah_env
   *   The Acquia Hosting environment.
   *
   * @return string
   */
  public static function acsfSitesJson($ah_group, $ah_env) {
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
  public static function ahFilesRoot($ah_group, $ah_env) {
    return '/mnt/files/' . $ah_group . '.' . $ah_env;
  }
}