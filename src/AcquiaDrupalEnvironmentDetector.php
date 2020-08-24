<?php

namespace Acquia\DrupalEnvironmentDetector;

/**
 * Detect various properties of the current Acquia environment.
 */
class AcquiaDrupalEnvironmentDetector {

  /**
   * Is AH env.
   */
  public static function isAhEnv() {
    return (bool) self::getAhEnv();
  }

  /**
   * Check if this is an ACSF env.
   *
   * Roughly duplicates the detection logic implemented by the ACSF module.
   *
   * @param mixed $ah_group
   *   The Acquia Hosting site / group name (e.g. my_subscription).
   * @param mixed $ah_env
   *   The Acquia Hosting environment name (e.g. 01dev).
   *
   * @return bool
   *   TRUE if this is an ACSF environment, FALSE otherwise.
   *
   * @see https://git.drupalcode.org/project/acsf/blob/8.x-2.62/acsf_init/lib/sites/default/acsf.settings.php#L14
   */
  public static function isAcsfEnv($ah_group = NULL, $ah_env = NULL) {
    if (is_null($ah_group)) {
      $ah_group = self::getAhGroup();
    }

    if (is_null($ah_env)) {
      $ah_env = self::getAhEnv();
    }

    if (empty($ah_group) || empty($ah_env)) {
      return FALSE;
    }

    return file_exists("/mnt/files/$ah_group.$ah_env/files-private/sites.json");
  }

  /**
   * Is AH prod.
   *
   * @param null $ah_env
   *
   * @return bool
   */
  public static function isAhProdEnv($ah_env = NULL) {
    if (is_null($ah_env)) {
      $ah_env = self::getAhEnv();
    }
    // ACE prod is 'prod'; ACSF can be '01live', '02live', ...
    return $ah_env == 'prod' || preg_match('/^\d*live$/', $ah_env);
  }

  /**
   * Is AH stage.
   *
   * @param null $ah_env
   *
   * @return bool
   */
  public static function isAhStageEnv($ah_env = NULL) {
    if (is_null($ah_env)) {
      $ah_env = self::getAhEnv();
    }
    // ACE staging is 'test' or 'stg'; ACSF is '01test', '02test', ...
    return preg_match('/^\d*test$/', $ah_env) || $ah_env == 'stg';
  }

  /**
   * Is AH dev.
   *
   * @param null $ah_env
   *
   * @return false|int
   */
  public static function isAhDevEnv($ah_env = NULL) {
    if (is_null($ah_env)) {
      $ah_env = self::getAhEnv();
    }
    // ACE dev is 'dev', 'dev1', ...; ACSF dev is '01dev', '02dev', ...
    return (preg_match('/^\d*dev\d*$/', $ah_env));
  }

  /**
   * Is AH ODE.
   *
   * @param null $ah_env
   *
   * @return false|int
   */
  public static function isAhOdeEnv($ah_env = NULL) {
    if (is_null($ah_env)) {
      $ah_env = self::getAhEnv();
    }
    // CDEs (formerly 'ODEs') can be 'ode1', 'ode2', ...
    return (preg_match('/^ode\d*$/', $ah_env));
  }

  /**
   * Is AH IDE.
   *
   * @param null $ah_env
   *
   * @return bool
   */
  public static function isAhIdeEnv($ah_env = NULL) {
    if (is_null($ah_env)) {
      $ah_env = self::getAhEnv();
    }
    return strtolower($ah_env) == 'ide';
  }

  /**
   * Is AH devcloud.
   */
  public static function isAhDevCloud() {
    return (!empty($_SERVER['HTTP_HOST']) && strstr($_SERVER['HTTP_HOST'], 'devcloud'));
  }

  /**
   * Get AH group.
   */
  public static function getAhGroup() {
    return getenv('AH_SITE_GROUP');
  }

  /**
   * Get AH env.
   */
  public static function getAhEnv() {
    return getenv('AH_SITE_ENVIRONMENT');
  }

  /**
   * Get AH realm.
   */
  public static function getAhRealm() {
    return getenv('AH_REALM');
  }

  /**
   * Get AH non production.
   */
  public static function getAhNonProduction() {
    return getenv('AH_NON_PRODUCTION');
  }

  /**
   * Get AH application UUID.
   */
  public static function getAhApplicationUuid() {
    return getenv('AH_APPLICATION_UUID');
  }

  /**
   * The path to the persistent file storage mount.
   *
   * It is used to store Drupal public and private files, but is only a common
   * base path and not tied to any particular site or type of file.
   *
   * @see https://docs.acquia.com/acquia-cloud/manage/files/about/
   */
  public static function getAhFilesRoot() {
    return '/mnt/files/' . self::getAhGroup() . '.' . self::getAhEnv();
  }

  /**
   * Get ACSF db.
   *
   * @return string|null
   *   ACSF db name.
   */
  public static function getAcsfDbName() {
    return isset($GLOBALS['gardens_site_settings']) && self::isAcsfEnv() ? $GLOBALS['gardens_site_settings']['conf']['acsf_db_name'] : NULL;
  }

  /**
   * If this isn't a Cloud environment, assume it's local.
   */
  public static function isLocalEnv() {
    return !self::isAhEnv();
  }

}
