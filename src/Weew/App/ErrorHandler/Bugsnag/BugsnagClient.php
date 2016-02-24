<?php

namespace Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use Exception;
use Weew\ErrorHandler\Errors\IError;

class BugsnagClient extends Bugsnag_Client {
    /**
     * @param IError $error
     *
     * @return bool
     */
    public function handleError(IError $error) {
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
    public function handleException(Exception $exception) {
        $this->exceptionHandler($exception);

        return false;
    }
}
