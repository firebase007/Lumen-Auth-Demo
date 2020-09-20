<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{



    protected $loggedInUser;

    protected $user;

    protected $headers;

    protected static $migrationsRun = false;
    
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }


    /**
     * Get the JSON data from the response and return as assoc. array
     *
     * @return array
     */
    public function getResponseData()
    {
        return json_decode(json_encode($this->response->getData()), true);
    }


    public function setUp(): void
    {
        parent::setUp();

        if (!static::$migrationsRun) {
            $this->artisan('migrate:refresh');
            $this->artisan('db:seed');
            static::$migrationsRun = true;
        }

        $this->beforeApplicationDestroyed(function () {
            // $this->artisan('migrate:rollback');
        });

        $users = factory(\App\Models\User::class)->times(2)->create();

        $this->loggedInUser = $users[0];

        $this->user = $users[1];

        $this->headers = [
            'Authorization' => "Token {$this->loggedInUser->token}"
        ];
    }
}
