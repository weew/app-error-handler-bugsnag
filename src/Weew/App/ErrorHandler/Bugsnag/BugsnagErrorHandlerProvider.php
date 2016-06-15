<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use Bugsnag_Error;
use Weew\Container\IContainer;
use Weew\ErrorHandler\IErrorHandler;

class BugsnagErrorHandlerProvider {
    /**
     * BugsnagErrorHandlerProvider constructor.
     *
     * @param IContainer $container
     */
    public function __construct(IContainer $container) {
        $container->set(IBugsnagErrorHandlerConfig::class, BugsnagErrorHandlerConfig::class);
        $container->set(BugsnagErrorHandler::class, [$this, 'createBugsnagErrorHandler'])->singleton();
    }

    /**
     * Enable error handler during initialization in order to
     * get notified about errors as early as possible.
     *
     * @param BugsnagErrorHandler $bugsnagErrorHandler
     */
    public function initialize(BugsnagErrorHandler $bugsnagErrorHandler) {
        $bugsnagErrorHandler->enableExceptionHandling();
        $bugsnagErrorHandler->enableErrorHandling();
    }

    /**
     * @param IBugsnagErrorHandlerConfig $bugsnagConfig
     * @param IErrorHandler $errorHandler
     *
     * @return BugsnagErrorHandler
     */
    public function createBugsnagErrorHandler(
        IBugsnagErrorHandlerConfig $bugsnagConfig,
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

        $bugsnagClient->setBeforeNotifyFunction(function(Bugsnag_Error $error) use ($bugsnagConfig) {
            array_splice($error->stacktrace->frames, 0, $bugsnagConfig->getNumberOfSkippedStackTraceLines());
        });

        if ($projectRoot = $bugsnagConfig->getProjectRoot()) {
            $bugsnagClient->setProjectRoot($projectRoot);
        }

        if ($hostname = $bugsnagConfig->getHostname()) {
            $bugsnagClient->setHostname($hostname);
        }

        return $bugsnagErrorHandler;
    }
}
