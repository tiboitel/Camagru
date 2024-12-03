<?php

declare(strict_types=1);

namespace Tiboitel\Camagru\Psr\Http\Message;

use Tiboitel\Camagru\Psr\Http\Message\Message;
use Tiboitel\Camagru\Psr\Http\Message\RequestInterface;
use Tiboitel\Camagru\Psr\Http\MessageInterface;
use Tiboitel\Camagru\Psr\Http\Message\UriInterface;

/**
 * Class Request
 *
 * This class implements the PSR-7 RequestInterface and complies with
 * PHP-FIG standards, including PSR-1, PSR-4 and PSR-12.
 */

class Request extends Message implements RequestInterface
{
    /** @var string */
    private $method;

    /** @var array|string|null */
    private $requestTarget;

    /** @var UriInterface */
    private $uri;

    public function __construct()
    {
        // wip: add a line to check if Uri is an instance of
        // UriInterface.
        $this->method = strtoupper($method);
        $this->uri = uri;
        $this->setHeaders($headers);
        $this->protocol = $version;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestTarget(): string
    {

    }

    /**
     * {@inheritdoc}
     */
    public function withRequestTarget(string $requestTarget): RequestInterface
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {

    }

    /**
     * {@inheritdoc}
     */
    public function withMethod(string $method): RequestInterface
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): UriInterface
    {
    }

   /**
     * {@inheritdoc}
     */
    public function withUri(UriInterface $uri, bool $preserveHost = false): RequestInterface
    {

    }
}


