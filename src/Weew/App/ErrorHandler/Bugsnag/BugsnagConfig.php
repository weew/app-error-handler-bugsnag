<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Weew\Config\IConfig;

class BugsnagConfig implements IBugsnagConfig {
    const CLIENT_ID = 'bugsnag.client_id';
    const ENVIRONMENT = 'bugsnag.env';
    const ENABLED_ENVIRONMENTS = 'bugsnag.enabled_environments';
    const TYPE = 'bugsnag.type';
    const METADATA = 'bugsnag.metadata';
    const AUTO_NOTIFY = 'bugsnag.auto_notify';
    const FILTERS = 'bugsnag.filters';
    const SEND_CODE = 'bugsnag.send_code';
    const PROJECT_ROOT = 'bugsnag.project_root';
    const HOSTNAME = 'bugsnag.hostname';

    /**
     * @var IConfig
     */
    protected $config;

    /**
     * BugsnagConfig constructor.
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
}
