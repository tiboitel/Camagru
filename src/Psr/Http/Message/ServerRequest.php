<?php

declare(strict_types=1);

namespace Tiboite\Camagru\Psr\Http\Message;

use Tiboitel\Camagru\Psr\Http\Message\ServerRequestInterface;
use Tiboitel\Camagru\Psr\Http\Message\UriInterface;
use Tiboitel\Camagru\Psr\Http\Message\StreamInterface;

/**
 * Class ServerRequest
 *
 * This class implements the PSR-7 ServerRequestInterface and complies with
 * PHP-FIG standards, including PSR-1, PSR-4, and PSR-12.
 */
class ServerRequest extends Request implements ServerRequestInterface
{
    /**
     * @var string The HTTP method of the request.
     */
    private string $method;

    /**
     * @var UriInterface The URI of the request.
     */
    private UriInterface $uri;

    /**
     * @var array The request headers.
     */
    private array $headers = [];

    /**
     * @var StreamInterface The body of the request.
     */
    private StreamInterface $body;

    /**
     * @var string The protocol version.
     */
    private string $protocolVersion = '1.1';

    /**
     * @var array The query parameters from the request URI.
     */
    private array $queryParams = [];

    /**
     * @var array Parsed body parameters.
     */
    private array $parsedBody = [];

    /**
     * @var array Server parameters ($_SERVER).
     */
    private array $serverParams = [];

    /**
     * @var array Uploaded files.
     */
    private array $uploadedFiles = [];

    /**
     * @var array Attributes derived from the request.
     */
    private array $attributes = [];

    /**
     * Constructor.
     *
     * @param string $method HTTP method.
     * @param UriInterface $uri Request URI.
     * @param array $headers Request headers.
     * @param StreamInterface $body Request body.
     * @param array $serverParams Server parameters ($_SERVER).
     */
    public function __construct(
        string $method,
        UriInterface $uri,
        array $headers = [],
        StreamInterface $body,
        array $serverParams = []
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->serverParams = $serverParams;
    }

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version): static
    {
        $new = clone $this;
        $new->protocolVersion = $version;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name): bool
    {
        return isset($this->headers[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name): array
    {
        return $this->headers[$name] ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name): string
    {
        return implode(', ', $this->getHeader($name));
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value): static
    {
        $new = clone $this;
        $new->headers[$name] = (array) $value;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value): static
    {
        $new = clone $this;
        $new->headers[$name] = array_merge($this->headers[$name] ?? [], (array) $value);
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name): static
    {
        $new = clone $this;
        unset($new->headers[$name]);
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body): static
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestTarget(): string
    {
        $target = $this->uri->getPath();
        $query = $this->uri->getQuery();

        return $query ? $target . '?' . $query : $target;
    }

    /**
     * {@inheritdoc}
     */
    public function withRequestTarget($requestTarget): static
    {
        throw new \InvalidArgumentException('Request target cannot be modified.');
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function withMethod($method): static
    {
        $new = clone $this;
        $new->method = $method;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookieParams(): array
    {
        return $this->cookies;
    }

    /**
     * {@inheritdoc}
     */
    public function withCookieParams(array $cookies): static
    {
        $new = clone $this;
        $new->cookies = $cookies;
        return $new;
    }


    /**
     * {@inheritdoc}
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withUri(UriInterface $uri, $preserveHost = false): static
    {
        $new = clone $this;
        $new->uri = $uri;

        if (!$preserveHost) {
            $new->headers['Host'] = [$uri->getHost()];
        }

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getServerParams(): array
    {
        return $this->serverParams;
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }

    /**
     * {@inheritdoc}
     */
    public function withUploadedFiles(array $uploadedFiles): static
    {
        $new = clone $this;
        $new->uploadedFiles = $uploadedFiles;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getParsedBody(): mixed
    {
        return $this->parsedBody;
    }

    /**
     * {@inheritdoc}
     */
    public function withParsedBody($data): static
    {
        $new = clone $this;
        $new->parsedBody = $data;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * {@inheritdoc}
     */
    public function withQueryParams(array $query): static
    {
        $new = clone $this;
        $new->queryParams = $query;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($name, $default = null): mixed
    {
        return $this->attributes[$name] ?? $default;
    }

    /**
     * {@inheritdoc}
     */
    public function withAttribute($name, $value): static
    {
        $new = clone $this;
        $new->attributes[$name] = $value;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutAttribute($name): static
    {
        $new = clone $this;
        unset($new->attributes[$name]);
        return $new;
    }
}

