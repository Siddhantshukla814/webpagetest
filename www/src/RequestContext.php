<?php

declare(strict_types=1);

namespace WebPageTest;

use WebPageTest\User;
use WebPageTest\CPClient;

class RequestContext
{
    private array $raw;
    private ?User $user;
    private ?CPClient $client;
    private bool $ssl_connection;
    private string $url_protocol;

    public function __construct(array $global_request, array $server = [])
    {
        $this->raw = $global_request;
        $this->user = null;
        $this->client = null;

        $https = isset($server['HTTPS']) && $server['HTTPS'] == 'on';
        $httpssl = isset($server['HTTP_SSL']) && $server['HTTP_SSL'] == 'On';
        $forwarded_proto = isset($server['HTTP_X_FORWARDED_PROTO']) && $server['HTTP_X_FORWARDED_PROTO'] == 'https';
        $this->ssl_connection = $https || $httpssl || $forwarded_proto;
        $this->url_protocol = $this->ssl_connection ? 'https' : 'http';
    }

    public function getRaw(): array
    {
        return $this->raw;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        if (isset($user)) {
            $this->user = $user;
        }
    }

    public function getClient(): ?CPClient
    {
        return $this->client;
    }

    public function setClient(?CPClient $client): void
    {
        if (isset($client)) {
            $this->client = $client;
        }
    }

    public function isSslConnection(): bool
    {
        return $this->ssl_connection;
    }

    public function getUrlProtocol(): string
    {
        return $this->url_protocol;
    }
}
