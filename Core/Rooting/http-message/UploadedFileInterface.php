<?php

namespace Core\Rooting\http_message;

interface UploadedFileInterface
{

    public function getStream();

    public function moveTo($targetPath);

    public function getSize();

    public function getError();
    
    public function getClientFilename();

    public function getClientMediaType();
}
