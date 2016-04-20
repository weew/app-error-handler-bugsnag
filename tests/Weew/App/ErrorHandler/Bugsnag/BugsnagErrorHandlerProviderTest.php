<?php

namespace Tests\Weew\App\ErrorHandler\Bugsnag;

use PHPUnit_Framework_TestCase;
use Weew\App\App;
use Weew\App\ErrorHandler\Bugsnag\BugsnagErrorHandlerConfig;
use Weew\App\ErrorHandler\Bugsnag\BugsnagErrorHandler;
use Weew\App\ErrorHandler\Bugsnag\BugsnagErrorHandlerProvider;
use Weew\App\ErrorHandler\ErrorHandlerProvider;
use Weew\Config\Config;

class BugsnagErrorHandlerProviderTest extends PHPUnit_Framework_TestCase {
    private function createApp() {
        $app = new App();
        $app->getKernel()->addProviders([
            ErrorHandlerProvider::class,
            BugsnagErrorHandlerProvider::class,
        ]);

        $config = new Config([
            BugsnagErrorHandlerConfig::CLIENT_ID => 'client_id',
            BugsnagErrorHandlerConfig::PROJECT_ROOT => __DIR__,
            BugsnagErrorHandlerConfig::HOSTNAME => 'hostname',
        ]);
        $app->getConfigLoader()->addConfig($config);

        $app->start();

        return $app;
    }

    public function test_run_with_provider() {
        $this->createApp();
    }

    public function test_bugsnag_client_instance_is_shared() {
        $app = $this->createApp();
        $client = $app->getContainer()->get(BugsnagErrorHandler::class);
        $this->assertTrue($client instanceof BugsnagErrorHandler);
    }
}
