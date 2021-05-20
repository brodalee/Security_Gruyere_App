<?php

namespace Core\Rooting\http_message;

interface ResponseInterface
{

    public function getStatusCode();

    public function withStatus($code, $reasonPhrase = '');

    public function getReasonPhrase();
}
