<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use Exception;
use Weew\Container\IContainer;
use Weew\ErrorHandler\Errors\IError;
use Weew\ErrorHandler\IErrorHandler;

class BugsnagProvider {
    /**
     * @var Bugsnag_Client;
     */
    protected $client;

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
        $client = new Bugsnag_Client($config->getClientId());
        $this->client = $client;

        $errorHandler->addErrorHandler([$this, 'handleError']);
        $errorHandler->addExceptionHandler([$this, 'handleException']);

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

        $container->set(Bugsnag_Client::class, $client);
    }

    /**
     * @param IError $error
     *
     * @return bool
     */
    public function handleError(IError $error) {
        $this->client->errorHandler(
            $error->getType(),
            $error->getMessage(),
            $error->getFile(),
            $error->getLine()
        );

        return false;
    }

    /**
     * @param Exception $exception
     *
     * @return bool
     */
    public function handleException(Exception $exception) {
        $this->client->exceptionHandler($exception);

        return false;
    }
}
