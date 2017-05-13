<?php

declare(strict_types=1);

/*
 * This file is part of YouTrack REST PHP.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\YouTrack\Tests\Unit\Services;

use Cog\YouTrack\Authenticators\NullAuthenticator;
use Cog\YouTrack\Contracts\YouTrackClient as YouTrackClientContract;
use Cog\YouTrack\Exceptions\AuthenticationException;
use Cog\YouTrack\Services\YouTrackClient;
use Cog\YouTrack\Tests\TestCase;

/**
 * Class YouTrackClientTest.
 *
 * @package Cog\YouTrack\Tests\Unit\Services
 */
class YouTrackClientTest extends TestCase
{
    /** @test */
    public function it_can_get_authenticator()
    {
        $client = $this->app->make(YouTrackClientContract::class);

        // TODO: Pass Stub Authenticator
        $this->setPrivateProperty($client, 'authenticator', new NullAuthenticator());

        $this->assertInstanceOf(NullAuthenticator::class, $client->getAuthenticator());
    }

    /** @test */
    public function it_can_set_authenticator()
    {
        $client = $this->app->make(YouTrackClientContract::class);

        // TODO: Pass Stub Authenticator
        $client->setAuthenticator(new NullAuthenticator());

        $this->assertAttributeInstanceOf(NullAuthenticator::class, 'authenticator', $client);
    }

    /** @test */
    public function it_throws_exception_on_null_authenticator_when_resolving_youtrack_client_from_container()
    {
        $this->expectException(AuthenticationException::class);

        $this->app['config']->set('youtrack.auth.drivers.null', [
            'class' => NullAuthenticator::class,
        ]);
        $this->app['config']->set('youtrack.auth.driver', 'null');

        $this->app->make(YouTrackClientContract::class);
    }

    /** @test */
    public function it_can_instantiate_youtrack_client_from_container_with_token_authenticator()
    {
        $this->app['config']->set('youtrack.auth.driver', 'token');

        $client = $this->app->make(YouTrackClientContract::class);

        $this->assertInstanceOf(YouTrackClient::class, $client);
    }

    /** @test */
    public function it_can_instantiate_youtrack_client_from_container_with_cookie_authenticator()
    {
        $this->app['config']->set('youtrack.auth.driver', 'cookie');

        $client = $this->app->make(YouTrackClientContract::class);

        $this->assertInstanceOf(YouTrackClient::class, $client);
    }
}
