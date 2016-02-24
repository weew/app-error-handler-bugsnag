<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Weew\Container\IContainer;
use Weew\ErrorHandler\IErrorHandler;

class BugsnagProvider {
    /**
     * @param BugsnagConfig $config
     * @param IErrorHandler $errorHandler
     * @param IContainer $container
     */
    public function boot(
        BugsnagConfig $config,
        IErrorHandler $errorHandler,
        IContainer $container
    ) {
        $client = new BugsnagClient($config->getClientId());

        $errorHandler->addErrorHandler([$client, 'handleError']);
        $errorHandler->addExceptionHandler([$client, 'handleException']);

        $client->setReleaseStage($config->getEnvironment());
        $client->setNotifyReleaseStages($config->getEnabledEnvironments());
        $client->setType($config->getType());
        $client->setMetaData($config->getMetadata());
        $client->setAutoNotify($config->getAutoNotify());
        $client->setFilters($config->getFilters());
        $client->setSendCode($config->getSendCode());

        if ($projectRoot = $config->getProjectRoot()) {
            $client->setProjectRoot($projectRoot);
        }

        if ($hostname = $config->getHostname()) {
            $client->setHostname($hostname);
        }

        $container->set(BugsnagClient::class, $client);
    }
}
