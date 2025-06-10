<?php

namespace Noovin\Http;

class Response
{
    protected int $status = 200;

    protected array $headers = [];

    protected ?string $content = null;

    public function prepare(): void
    {
        if (is_null($this->content)) {
            $this->removeHeader("Content-Type");
            $this->removeHeader("Content-Length");
        } else {
            $this->setHeader("Content-Length", strlen($this->content));
        }
    }

    public static function json(array $data): self
    {
        return (new self())
            ->setContentType("application/json")
            ->setContent(json_encode($data));
    }

    public static function text(string $text): self
    {
        return (new self())
            ->setContentType("text/plain")
            ->setContent($text);
    }

    public static function redirect(string $url, int $status = 302): self
    {
        return (new self())
            ->setStatus($status)
            ->setHeader("Location", $url);
    }

    public function status(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function setHeader(string $header, string $value): self
    {
        $this->headers[strtolower($header)] = $value;
        return $this;
    }

    public function setContentType(string $contentType): self
    {
        $this->setHeader("Content-Type", $contentType);
        return $this;
    }

    public function removeHeader(string $header): self
    {
        unset($this->headers[strtolower($header)]);
        return $this;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }
}
