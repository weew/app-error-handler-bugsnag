<?php

namespace Tests\Weew\App\ErrorHandler\Bugsnag;

use PHPUnit_Framework_TestCase;
use Weew\App\ErrorHandler\Bugsnag\BugsnagConfig;
use Weew\Config\Config;
use Weew\Config\Exceptions\MissingConfigException;

class BugsnagConfigTest extends PHPUnit_Framework_TestCase {
    public function test_getters() {
        $config = new Config();
        $config->set(BugsnagConfig::CLIENT_ID, 'client_id');
        $config->set(BugsnagConfig::ENVIRONMENT, 'environment');
        $config->set(BugsnagConfig::FILTERS, ['filters']);
        $config->set(BugsnagConfig::METADATA, ['metadata']);
        $config->set(BugsnagConfig::ENABLED_ENVIRONMENTS, ['notify_in']);
        $config->set(BugsnagConfig::SEND_CODE, 'send_code');
        $config->set(BugsnagConfig::TYPE, 'type');
        $config->set(BugsnagConfig::AUTO_NOTIFY, 'auto_notify');
        $config->set(BugsnagConfig::PROJECT_ROOT, 'project_root');
        $config->set(BugsnagConfig::HOSTNAME, 'hostname');

        $settings = new BugsnagConfig($config);

        $this->assertEquals('client_id', $settings->getClientId());
        $this->assertEquals('environment', $settings->getEnvironment());
        $this->assertEquals(['filters'], $settings->getFilters());
        $this->assertEquals(['metadata'], $settings->getMetadata());
        $this->assertEquals(['notify_in'], $settings->getEnabledEnvironments());
        $this->assertEquals('send_code', $settings->getSendCode());
        $this->assertEquals('type', $settings->getType());
        $this->assertEquals('auto_notify', $settings->getAutoNotify());
        $this->assertEquals('project_root', $settings->getProjectRoot());
        $this->assertEquals('hostname', $settings->getHostname());
    }

    public function test_create_without_client_id() {
        $this->setExpectedException(MissingConfigException::class);
        new BugsnagConfig(new Config());
    }
}
