<?php

namespace Tests\Weew\App\ErrorHandler\Bugsnag;

use PHPUnit_Framework_TestCase;
use Weew\App\ErrorHandler\Bugsnag\BugsnagErrorHandlerConfig;
use Weew\Config\Config;
use Weew\Config\Exceptions\MissingConfigException;

class BugsnagErrorHandlerConfigTest extends PHPUnit_Framework_TestCase {
    public function test_getters() {
        $config = new Config();
        $config->set(BugsnagErrorHandlerConfig::CLIENT_ID, 'client_id');
        $config->set(BugsnagErrorHandlerConfig::ENVIRONMENT, 'environment');
        $config->set(BugsnagErrorHandlerConfig::FILTERS, ['filters']);
        $config->set(BugsnagErrorHandlerConfig::METADATA, ['metadata']);
        $config->set(BugsnagErrorHandlerConfig::ENABLED_ENVIRONMENTS, ['notify_in']);
        $config->set(BugsnagErrorHandlerConfig::SEND_CODE, 'send_code');
        $config->set(BugsnagErrorHandlerConfig::TYPE, 'type');
        $config->set(BugsnagErrorHandlerConfig::AUTO_NOTIFY, 'auto_notify');
        $config->set(BugsnagErrorHandlerConfig::PROJECT_ROOT, 'project_root');
        $config->set(BugsnagErrorHandlerConfig::HOSTNAME, 'hostname');
        $config->set(BugsnagErrorHandlerConfig::NUMBER_OF_SKIPPED_STACK_TRACE_LINES, 10);

        $settings = new BugsnagErrorHandlerConfig($config);

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

        $this->assertEquals(10, $settings->getNumberOfSkippedStackTraceLines());
        $config->remove(BugsnagErrorHandlerConfig::NUMBER_OF_SKIPPED_STACK_TRACE_LINES);
        $this->assertEquals(5, $settings->getNumberOfSkippedStackTraceLines());
    }

    public function test_create_without_client_id() {
        $this->setExpectedException(MissingConfigException::class);
        new BugsnagErrorHandlerConfig(new Config());
    }
}
