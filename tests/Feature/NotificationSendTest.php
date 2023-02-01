<?php

namespace Tests\Feature;

use App\Facades\Sms;
use App\Models\User;
use App\NotificationDrivers\DriverAbstract;
use App\NotificationDrivers\KavenegarDriver;
use App\Services\SmsSender;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Mockery\MockInterface;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use Tests\TestCase;

class NotificationSendTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * test send message
     *
     * @return void
     */
    public function test_register_user()
    {
        $user = User::factory()->create();

        Notification::fake();

        $data = [
            "message"  => "test message text",
            "driver"   => env("NOTIFICATION_DRIVER"),
            "receptor" => "09118412257",
        ];

        $this->actingAs($user)
             ->postJson('/api/notification/send', $data)
             ->assertStatus(200)
        ;

        Notification::assertCount(1);
    }
}
