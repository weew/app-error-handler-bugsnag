<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use Weew\Container\IContainer;
use Weew\ErrorHandler\IErrorHandler;

class BugsnagProvider {
    /**
     * @param BugsnagConfig $bugsnagConfig
     * @param IErrorHandler $errorHandler
     * @param IContainer $container
     */
    public function boot(
        BugsnagConfig $bugsnagConfig,
        IErrorHandler $errorHandler,
        IContainer $container
    ) {
        $bugsnagClient = new Bugsnag_Client($bugsnagConfig->getClientId());
        $bugsnagErrorHandler = new BugsnagErrorHandler(
            $bugsnagClient, $errorHandler
        );
        $bugsnagErrorHandler->enableErrorHandling();
        $bugsnagErrorHandler->enableErrorHandling();

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

        $container->set(Bugsnag_Client::class, $bugsnagClient);
    }
}
