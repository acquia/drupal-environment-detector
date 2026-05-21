<?php

use Acquia\DrupalEnvironmentDetector\AcquiaDrupalEnvironmentDetector;
use Acquia\DrupalEnvironmentDetector\FilePaths;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests the EnvironmentDetector class.
 */
class EnvironmentDetectorTest extends TestCase {

  /**
   * Tests EnvironmentDetector::isAhDevEnv().
   *
   * @param string $ah_site_env
   *   The name of the site environment.
   * @param string $expected_env
   *   Environment type.
   */
  #[DataProvider('providerTestIsEnv')]
  public function testIsAhDevEnv($ah_site_env, $expected_env) {
    putenv("AH_SITE_ENVIRONMENT=$ah_site_env");
    $this::assertEquals($expected_env === 'dev', AcquiaDrupalEnvironmentDetector::isAhDevEnv());
  }

  /**
   * Tests EnvironmentDetector::isAhStageEnv().
   *
   * @param string $ah_site_env
   *   The name of the site environment.
   * @param string $expected_env
   *   Environment type.
   */
  #[DataProvider('providerTestIsEnv')]
  public function testIsAhStageEnv($ah_site_env, $expected_env) {
    putenv("AH_SITE_ENVIRONMENT=$ah_site_env");
    $this::assertEquals($expected_env === 'stage', AcquiaDrupalEnvironmentDetector::isAhStageEnv());
  }

  /**
   * Tests EnvironmentDetector::isAhProdEnv().
   *
   * @param string $ah_site_env
   *   The name of the site environment.
   * @param string $expected_env
   *   Environment type.
   */
  #[DataProvider('providerTestIsEnv')]
  public function testIsAhProdEnv($ah_site_env, $expected_env) {
    putenv("AH_SITE_ENVIRONMENT=$ah_site_env");
    $this::assertEquals($expected_env === 'prod', AcquiaDrupalEnvironmentDetector::isAhProdEnv());
  }

  /**
   * Tests EnvironmentDetector::isAhOdeEnv().
   *
   * @param string $ah_site_env
   *   The name of the site environment.
   * @param string $expected_env
   *   Environment type.
   */
  #[DataProvider('providerTestIsEnv')]
  public function testIsAhOdeEnv($ah_site_env, $expected_env) {
    putenv("AH_SITE_ENVIRONMENT=$ah_site_env");
    $this::assertEquals($expected_env === 'ode', AcquiaDrupalEnvironmentDetector::isAhOdeEnv());
  }

  /**
   * Tests EnvironmentDetector::isAcquiaLandoEnv().
   */
  public function testIsAcquiaLandoEnv() {
    putenv("AH_SITE_ENVIRONMENT=LANDO");
    $this::assertEquals('lando', AcquiaDrupalEnvironmentDetector::isAcquiaLandoEnv());
  }

  /**
   * Tests EnvironmentDetector::getAhEnvGroup().
   *
   * @param string $ah_site_env
   *   The name of the site environment.
   * @param string $expected_env
   *   Environment type.
   */
  #[DataProvider('providerTestIsEnv')]
  public function testGetAhEnvGroup($ah_site_env, $expected_env) {
    putenv("AH_SITE_ENVIRONMENT=$ah_site_env");
    $this::assertEquals($expected_env, AcquiaDrupalEnvironmentDetector::getAhEnvGroup($ah_site_env));
  }

  /**
   * Provides values to testIsAhEnv tests.
   *
   * @return array
   *   An array of values to test, environment name mapped to environment type.
   */
  public static function providerTestIsEnv(): array {
    return [
      ['dev', 'dev'],
      ['dev1', 'dev'],
      ['01dev', 'dev'],
      ['02dev', 'dev'],
      ['test', 'stage'],
      ['stg', 'stage'],
      ['stage', 'stage'],
      ['01test', 'stage'],
      ['02test', 'stage'],
      ['prod', 'prod'],
      ['01live', 'prod'],
      ['02live', 'prod'],
      ['ode1', 'ode'],
      ['ode2', 'ode'],
      ['01update', 'other_acquia_env'],
      ['', 'non_acquia_env'],
    ];
  }

  /**
   * Tests EnvironmentDetector::isLandoEnv().
   */
  public function testIsLandoEnv() {
    putenv("LANDO=ON");
    $this::assertTrue(AcquiaDrupalEnvironmentDetector::isLandoEnv());
  }

  /**
   * Tests EnvironmentDetector::isCodeStudioEnv().
   *
   * @param string $gitlab_ci_job_id
   *   Git lab CI job id.
   * @param string $gitlab_token
   *   Git lab CI token.
   * @param bool $expected_value
   *   Expected outcome whether code studio pipeline or not.
   */
  #[DataProvider('providerTestIsCodeStudio')]
  public function testIsCodeStudioEnv($gitlab_ci_job_id, $gitlab_token, $expected_value) {
    putenv("CI_JOB_ID=$gitlab_ci_job_id");
    putenv("ACQUIA_GLAB_TOKEN_NAME=$gitlab_token");
    $this::assertEquals($expected_value, AcquiaDrupalEnvironmentDetector::isCodeStudioEnv());
    putenv("CI_JOB_ID");
    putenv("ACQUIA_GLAB_TOKEN_NAME");
  }

  /**
   * Provides values to testIsCodeStudioEnv tests.
   *
   * @return array
   *   An array of values to test, environment variables value with outcome.
   */
  public static function providerTestIsCodeStudio(): array {
    return [
      [
        'TestJobId',
        'TestToken',
        TRUE,
      ],
      [
        '',
        'TestToken',
        FALSE,
      ],
      [
        'TestJobId',
        '',
        FALSE,
      ],
      [
        '',
        '',
        FALSE,
      ],
    ];
  }

  /**
   * Tests EnvironmentDetector::isAhMeoEnv().
   */
  public function testIsAcquiaMeoEnvTrue() {
    putenv('AH_ENVIRONMENT_TYPE=meo');
    $this::assertTrue(AcquiaDrupalEnvironmentDetector::isAhMeoEnv());
    putenv('AH_ENVIRONMENT_TYPE');
  }

  /**
   * Tests EnvironmentDetector::isAhMeoEnv() when not set.
   */
  public function testIsAcquiaMeoEnvFalse() {
    putenv('AH_ENVIRONMENT_TYPE');
    $this::assertFalse(AcquiaDrupalEnvironmentDetector::isAhMeoEnv());
  }

  /**
   * Tests that getAhEnvGroup() returns 'meo' in a MEO environment.
   *
   * Even when $ah_env matches a standard name (e.g. 'prod'), MEO must win
   * because AH_ENVIRONMENT_TYPE takes precedence over $ah_env naming.
   */
  public function testGetAhEnvGroupMeo() {
    putenv('AH_ENVIRONMENT_TYPE=meo');
    // Standard env name that would normally return 'prod' — MEO must take precedence.
    $this::assertEquals('meo', AcquiaDrupalEnvironmentDetector::getAhEnvGroup('prod'));
    // Also verify with a non-standard env name.
    $this::assertEquals('meo', AcquiaDrupalEnvironmentDetector::getAhEnvGroup('meoprod'));
    putenv('AH_ENVIRONMENT_TYPE');
  }

  /**
   * Tests FilePaths::ahSettingsFile() returns the MEO common include in MEO.
   */
  public function testAhSettingsFileReturnsMeoPathInMeoEnv() {
    putenv('AH_ENVIRONMENT_TYPE=meo');
    $this::assertEquals(
      '/var/www/site-php/mysite/mysite-settings.common.inc',
      FilePaths::ahSettingsFile('mysite', 'default')
    );
    putenv('AH_ENVIRONMENT_TYPE');
  }

  /**
   * Tests FilePaths::ahSettingsFile() returns the standard path outside MEO.
   */
  public function testAhSettingsFileReturnsStandardPathOutsideMeo() {
    putenv('AH_ENVIRONMENT_TYPE');
    $this::assertEquals(
      '/var/www/site-php/mysite/mysite-settings.inc',
      FilePaths::ahSettingsFile('mysite', 'default')
    );
  }

  /**
   * Tests FilePaths::ahSitesFile() returns path in MEO environment.
   */
  public function testAhSitesFileInMeoEnv() {
    putenv('AH_ENVIRONMENT_TYPE=meo');
    $this::assertEquals(
      '/var/www/site-php/mysite/mysite-sites.inc',
      FilePaths::ahSitesFile('mysite')
    );
    putenv('AH_ENVIRONMENT_TYPE');
  }

  /**
   * Tests FilePaths::ahSitesFile() returns NULL outside MEO.
   */
  public function testAhSitesFileOutsideMeoEnv() {
    putenv('AH_ENVIRONMENT_TYPE');
    $this::assertNull(FilePaths::ahSitesFile('mysite'));
  }

}
