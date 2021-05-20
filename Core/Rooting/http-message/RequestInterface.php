<?php

namespace Core\Rooting\http_message;

interface RequestInterface
{

    public function getRequestTarget();

    public function withRequestTarget($requestTarget);

    public function getMethod();

    public function withMethod($method);

    public function getUri();

    public function withUri(UriInterface $uri, $preserveHost = false);
}
