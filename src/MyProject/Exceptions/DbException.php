<?php

namespace MyProject\Exceptions;

class DbException extends \Exception implements Throwable
{
    public function getMessage(): string
    {
        return 'Ошибка при подключении к базе данных';
    }

    public function getCode(): int
    {
        return 404;
    }

    public function getFile(): string
    {
        $this->file;
    }

    public function getLine(): int
    {
        $this->line;
    }

    public function getTrace(): array
    {
        $this->trace;
    }
}

