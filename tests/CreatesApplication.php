<?php
namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function ajaxJSON($method, $uri, array $data=[]) {
        return $this->json($method,$uri,$data,[
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
            //'Accept' => 'application/json',
        ]);
    }

    protected function setUp() : void
    {
        parent::setUp();
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }
}
