<?php

namespace Weew\App\ErrorHandler\Bugsnag;

interface IBugsnagErrorHandlerConfig {
    /**
     * @return string
     */
    function getClientId();

    /**
     * @return string
     */
    function getEnvironment();

    /**
     * @return array
     */
    function getEnabledEnvironments();

    /**
     * @return string
     */
    function getType();

    /**
     * @return bool
     */
    function getAutoNotify();

    /**
     * @return array
     */
    function getMetadata();

    /**
     * @return array
     */
    function getFilters();

    /**
     * @return bool
     */
    function getSendCode();

    /**
     * @return string
     */
    function getProjectRoot();

    /**
     * @return string
     */
    function getHostname();
}
