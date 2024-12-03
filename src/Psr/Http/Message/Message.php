<?php

declare(strict_types=1);

namespace Tiboitel\Camagru\Psr\Http\Message;

use Tiboitel\Camagru\Psr\Http\Message\MessageInterface;

abstract class Message implements ServerRequestInterface
{
    abstract function getProtocolVersion(): string;
    abstract function withProtocolVersion(string $version): MessageInterface;
    abstract function hasHeader(string $name): bool;
    abstract function getHeader(string $name): array;
    abstract function getHeaderLine(string $name): string;
    abstract function withHeader(string $name, $value): MessageInterface;
    abstract function withAddedHeader(string $name, $value): MessageInterface;
    abstract function withoutHeader(string $name): MessageInterface;
    abstract function getBody(): StreamInterface;
    abstract function withBody(StreamInterface $bodyi): MessageInterface;
}
