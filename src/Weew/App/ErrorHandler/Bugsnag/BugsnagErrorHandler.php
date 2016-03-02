<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use Exception;
use Weew\ErrorHandler\Errors\IError;
use Weew\ErrorHandler\IErrorHandler;

class BugsnagErrorHandler {
    /**
     * @var Bugsnag_Client
     */
    private $bugsnagClient;

    /**
     * @var IErrorHandler
     */
    private $errorHandler;

    /**
     * BugsnagErrorHandler constructor.
     *
     * @param Bugsnag_Client $bugsnagClient
     * @param IErrorHandler $errorHandler
     */
    public function __construct(
        Bugsnag_Client $bugsnagClient,
        IErrorHandler $errorHandler
    ) {
        $this->setBugsnagClient($bugsnagClient);
        $this->setErrorHandler($errorHandler);
    }

    /**
     * @return IErrorHandler¨
     */
    public function getErrorHandler() {
        return $this->errorHandler;
    }

    /**
     * @param IErrorHandler $errorHandler
     */
    public function setErrorHandler(IErrorHandler $errorHandler) {
        $this->errorHandler = $errorHandler;
    }

    /**
     * @return Bugsnag_Client
     */
    public function getBugsnagClient() {
        return $this->bugsnagClient;
    }

    /**
     * @param Bugsnag_Client $bugsnagClient
     */
    public function setBugsnagClient(Bugsnag_Client $bugsnagClient) {
        $this->bugsnagClient = $bugsnagClient;
    }

    /**
     * Enable error handling.
     */
    public function enableErrorHandling() {
        $this->errorHandler->addErrorHandler(
            [$this, 'handleError']
        );
    }

    /**
     * Enable exception handling.
     */
    public function enableExceptionHandling() {
        $this->errorHandler->addExceptionHandler(
            [$this, 'handleException']
        );
    }

    /**
     * @param IError $error
     *
     * @return bool
     */
    public function handleError(IError $error) {
        $this->bugsnagClient->errorHandler(
            $error->getCode(),
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
        $this->bugsnagClient->exceptionHandler($exception);

        return false;
    }
}
