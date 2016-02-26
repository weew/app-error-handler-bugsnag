<?php

namespace Tests\Weew\App\ErrorHandler\Bugsnag;

use Bugsnag_Client;
use PHPUnit_Framework_TestCase;
use Weew\App\App;
use Weew\App\ErrorHandler\Bugsnag\BugsnagConfig;
use Weew\App\ErrorHandler\Bugsnag\BugsnagProvider;
use Weew\App\ErrorHandler\ErrorHandlingProvider;

class BugsnagProviderTest extends PHPUnit_Framework_TestCase {
    private function createApp() {
        $app = new App();
        $app->getKernel()->addProviders([
            ErrorHandlingProvider::class,
            BugsnagProvider::class,
        ]);

        $app->loadConfig()->merge([
            BugsnagConfig::CLIENT_ID => 'client_id',
            BugsnagConfig::PROJECT_ROOT => __DIR__,
            BugsnagConfig::HOSTNAME => 'hostname',
        ]);

        $app->start();

        return $app;
    }

    public function test_run_with_provider() {
        $this->createApp();
    }

    public function test_bugsnag_client_instance_is_shared() {
        $app = $this->createApp();
        $client = $app->getContainer()->get(Bugsnag_Client::class);
        $this->assertTrue($client instanceof Bugsnag_Client);
    }
}
