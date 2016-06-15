<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Weew\Config\IConfig;

class BugsnagErrorHandlerConfig implements IBugsnagErrorHandlerConfig {
    const CLIENT_ID = 'bugsnag_error_handler.client_id';
    const ENVIRONMENT = 'bugsnag_error_handler.env';
    const ENABLED_ENVIRONMENTS = 'bugsnag_error_handler.enabled_environments';
    const TYPE = 'bugsnag_error_handler.type';
    const METADATA = 'bugsnag_error_handler.metadata';
    const AUTO_NOTIFY = 'bugsnag_error_handler.auto_notify';
    const FILTERS = 'bugsnag_error_handler.filters';
    const SEND_CODE = 'bugsnag_error_handler.send_code';
    const PROJECT_ROOT = 'bugsnag_error_handler.project_root';
    const HOSTNAME = 'bugsnag_error_handler.hostname';
    const NUMBER_OF_SKIPPED_STACK_TRACE_LINES = 'bugsnag_error_handler.number_of_skipped_stack_trace_lines';

    /**
     * @var IConfig
     */
    protected $config;

    /**
     * BugsnagErrorHandlerConfig constructor.
     *
     * @param IConfig $config
     */
    public function __construct(IConfig $config) {
        $this->config = $config;

        $config->ensure(self::CLIENT_ID, 'Missing bugsnag client id.');
    }

    /**
     * @return string
     */
    public function getClientId() {
        return $this->config->get(self::CLIENT_ID);
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public function getEnvironment($default = 'dev') {
        return $this->config->get(self::ENVIRONMENT, $default);
    }

    /**
     * @param array $default
     *
     * @return array
     */
    public function getEnabledEnvironments($default = ['stage', 'prod']) {
        return $this->config->get(self::ENABLED_ENVIRONMENTS, $default);
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public function getType($default = 'php') {
        return $this->config->get(self::TYPE, $default);
    }

    /**
     * @param bool $default
     *
     * @return bool
     */
    public function getAutoNotify($default = true) {
        return $this->config->get(self::AUTO_NOTIFY, $default);
    }

    /**
     * @param array $default
     *
     * @return array
     */
    public function getMetadata(array $default = []) {
        return $this->config->get(self::METADATA, $default);
    }

    /**
     * @param array $default
     *
     * @return mixed
     */
    public function getFilters(array $default = ['credit_card', 'password']) {
        return $this->config->get(self::FILTERS, $default);
    }

    /**
     * @param bool $default
     *
     * @return bool
     */
    public function getSendCode($default = true) {
        return $this->config->get(self::SEND_CODE, $default);
    }

    /**
     * @param null $default
     *
     * @return string
     */
    public function getProjectRoot($default = null) {
        return $this->config->get(self::PROJECT_ROOT, $default);
    }

    /**
     * @param null $default
     *
     * @return string
     */
    public function getHostname($default = null) {
        return $this->config->get(self::HOSTNAME, $default);
    }

    /**
     * @return int
     */
    public function getNumberOfSkippedStackTraceLines() {
        return $this->config->get(self::NUMBER_OF_SKIPPED_STACK_TRACE_LINES, 0);
    }
}
