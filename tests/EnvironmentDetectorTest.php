<?php

use Acquia\DrupalEnvironmentDetector\AcquiaDrupalEnvironmentDetector;
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
   *
   * @dataProvider providerTestIsEnv
   */
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
   *
   * @dataProvider providerTestIsEnv
   */
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
   *
   * @dataProvider providerTestIsEnv
   */
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
   *
   * @dataProvider providerTestIsEnv
   */
  public function testIsAhOdeEnv($ah_site_env, $expected_env) {
    putenv("AH_SITE_ENVIRONMENT=$ah_site_env");
    $this::assertEquals($expected_env === 'ode', AcquiaDrupalEnvironmentDetector::isAhOdeEnv());
  }

  /**
   * Tests EnvironmentDetector::isAcquiaLandoEnv().
   *
   * @param string $ah_site_env
   *   The name of the site environment.
   * @param string $expected_env
   *   Environment type.
   *
   * @dataProvider providerTestIsEnv
   */
  public function testIsAcquiaLandoEnv($ah_site_env, $expected_env) {
    putenv("AH_SITE_ENVIRONMENT=$ah_site_env");
    $this::assertEquals($expected_env === 'lando', AcquiaDrupalEnvironmentDetector::isAcquiaLandoEnv());
  }

  /**
   * Provides values to testIsAhEnv tests.
   *
   * @return array
   *   An array of values to test, environment name mapped to environment type.
   */
  public function providerTestIsEnv() {
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
      ['LANDO', 'lando'],
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
   *
   * @dataProvider providerTestIsCodeStudio
   */
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
  public function providerTestIsCodeStudio() {
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

}
