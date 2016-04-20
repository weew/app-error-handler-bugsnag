<?php

namespace Tests\Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use Exception;
use PHPUnit_Framework_TestCase;
use Weew\App\ErrorHandler\Bugsnag\BugsnagErrorHandler;
use Weew\ErrorHandler\ErrorHandler;
use Weew\ErrorHandler\Errors\RecoverableError;

class BugsnagErrorHandlerErrorHandlerTest extends PHPUnit_Framework_TestCase {
    public function test_enable_error_handling() {
        $errorHandler = new ErrorHandler();
        $bugsnagErrorHandler = new BugsnagErrorHandler(
            new Bugsnag_Client('client_id'), $errorHandler
        );
        $this->assertEquals(0, count($errorHandler->getFatalErrorHandlers()));
        $this->assertEquals(0, count($errorHandler->getRecoverableErrorHandlers()));
        $bugsnagErrorHandler->enableErrorHandling();
        $this->assertEquals(1, count($errorHandler->getFatalErrorHandlers()));
        $this->assertEquals(1, count($errorHandler->getRecoverableErrorHandlers()));
    }

    public function test_enable_exception_handling() {
        $errorHandler = new ErrorHandler();
        $bugsnagErrorHandler = new BugsnagErrorHandler(
            new Bugsnag_Client('client_id'), $errorHandler
        );
        $this->assertEquals(0, count($errorHandler->getExceptionHandlers()));
        $bugsnagErrorHandler->enableExceptionHandling();
        $this->assertEquals(1, count($errorHandler->getExceptionHandlers()));
    }

    public function test_handle_error() {
        $bugsnagErrorHandler = new BugsnagErrorHandler(
            new Bugsnag_Client('client_id'), new ErrorHandler()
        );
        $bugsnagErrorHandler->handleError(
            new RecoverableError(1, 'error', 'file', 1)
        );
    }

    public function test_handle_exception() {
        $bugsnagErrorHandler = new BugsnagErrorHandler(
            new Bugsnag_Client('client_id'), new ErrorHandler()
        );
        $bugsnagErrorHandler->handleException(new Exception());
    }

    public function test_get_and_set_bugsnag_client() {
        $errorHandler = new ErrorHandler();
        $bugsnagClient = new Bugsnag_Client('client_id');
        $bugsnagErrorHandler = new BugsnagErrorHandler($bugsnagClient, $errorHandler);

        $this->assertTrue($bugsnagErrorHandler->getBugsnagClient() === $bugsnagClient);
    }

    public function test_get_and_set_error_handler() {
        $errorHandler = new ErrorHandler();
        $bugsnagClient = new Bugsnag_Client('client_id');
        $bugsnagErrorHandler = new BugsnagErrorHandler($bugsnagClient, $errorHandler);

        $this->assertTrue($bugsnagErrorHandler->getErrorHandler() === $errorHandler);
    }
}
