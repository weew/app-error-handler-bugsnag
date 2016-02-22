<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use Exception;
use Weew\ErrorHandler\Errors\IError;
use Weew\ErrorHandler\IErrorHandler;

class BugsnagClient extends Bugsnag_Client {
    /**
     * @param IErrorHandler $errorHandler
     */
    public function enableErrorHandling(IErrorHandler $errorHandler) {
        $errorHandler->addErrorHandler([$this, 'customErrorHandler']);
    }

    /**
     * @param IErrorHandler $errorHandler
     */
    public function enableExceptionHandling(IErrorHandler $errorHandler) {
        $errorHandler->addExceptionHandler([$this, 'customExceptionHandler']);
    }

    /**
     * @param IError $error
     *
     * @return bool
     */
    public function customErrorHandler(IError $error) {
        $this->errorHandler(
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
    public function customExceptionHandler(Exception $exception) {
        $this->exceptionHandler($exception);

        return false;
    }
}
