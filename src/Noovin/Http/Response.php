<?php

namespace Noovin\Http;

class Response {
    protected int $status = 200;

    protected array $headers = [];

    protected ?string $content = null;

    public function status(): int {
        return $this->status;
    }

    public function setStatus(int $status): self {
        $this->status = $status;
        return $this;
    }

    public function headers(): array {
        return $this->headers;
    }

    public function setHeader(string $header, string $value): self {
        $this->headers[strtolower($header)] = $value;
        return $this;
    }

    public function removeHeader(string $header): self {
        unset($this->headers[strtolower($header)]);
        return $this;
    }

    public function content(): ?string {
        return $this->content;
    }

    public function setContent(?string $content): self {
        $this->content = $content;
        return $this;
    }

    public function prepare(): void {
        if (is_null($this->content)) {
            $this->removeHeader("Content-Type");
            $this->removeHeader("Content-Length");
        } else {
            $this->setHeader("Content-Length", strlen($this->content));
        }
    }
}
