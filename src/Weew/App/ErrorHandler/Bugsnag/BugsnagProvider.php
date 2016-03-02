<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use Weew\Container\IContainer;
use Weew\ErrorHandler\IErrorHandler;

class BugsnagProvider {
    /**
     * BugsnagProvider constructor.
     *
     * @param IContainer $container
     */
    public function __construct(IContainer $container) {
        $container->set(IBugsnagConfig::class, BugsnagConfig::class);
        $container->set(BugsnagErrorHandler::class, [$this, 'createBugsnagErrorHandler'])->singleton();
    }

    /**
     * Enable error handler during initialization in order to
     * get notified about errors as early as possible.
     *
     * @param BugsnagErrorHandler $bugsnagErrorHandler
     */
    public function initialize(BugsnagErrorHandler $bugsnagErrorHandler) {
        $bugsnagErrorHandler->enableErrorHandling();
        $bugsnagErrorHandler->enableErrorHandling();
    }

    /**
     * @param IBugsnagConfig $bugsnagConfig
     * @param IErrorHandler $errorHandler
     *
     * @return BugsnagErrorHandler
     */
    public function createBugsnagErrorHandler(
        IBugsnagConfig $bugsnagConfig,
        IErrorHandler $errorHandler
    ) {
        $bugsnagClient = new Bugsnag_Client($bugsnagConfig->getClientId());
        $bugsnagErrorHandler = new BugsnagErrorHandler(
            $bugsnagClient, $errorHandler
        );

        $bugsnagClient->setReleaseStage($bugsnagConfig->getEnvironment());
        $bugsnagClient->setNotifyReleaseStages($bugsnagConfig->getEnabledEnvironments());
        $bugsnagClient->setType($bugsnagConfig->getType());
        $bugsnagClient->setMetaData($bugsnagConfig->getMetadata());
        $bugsnagClient->setAutoNotify($bugsnagConfig->getAutoNotify());
        $bugsnagClient->setFilters($bugsnagConfig->getFilters());
        $bugsnagClient->setSendCode($bugsnagConfig->getSendCode());

        if ($projectRoot = $bugsnagConfig->getProjectRoot()) {
            $bugsnagClient->setProjectRoot($projectRoot);
        }

        if ($hostname = $bugsnagConfig->getHostname()) {
            $bugsnagClient->setHostname($hostname);
        }

        return $bugsnagErrorHandler;
    }
}
