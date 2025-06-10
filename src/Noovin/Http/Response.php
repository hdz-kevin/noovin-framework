<?php

namespace Noovin\Http;

/**
 * HTTP Response that will be sent to the client.
 */
class Response
{
    /**
     * @var integer Response HTTP status code.
     */
    protected int $status = 200;

    /**
     * @var array<string, string> Response HTTP headers.
     */
    protected array $headers = [];

    /**
     * @var string|null Response content.
     */
    protected ?string $content = null;

    /**
     * Prepare the response to be sent to the client.
     *
     * @return void
     */
    public function prepare(): void
    {
        if (is_null($this->content)) {
            $this->removeHeader("Content-Type");
            $this->removeHeader("Content-Length");
        } else {
            $this->setHeader("Content-Length", strlen($this->content));
        }
    }

    /**
     * Create a new JSON response.
     *
     * @param array $data
     * @return self
     */
    public static function json(array $data): self
    {
        return (new self())
            ->setContentType("application/json")
            ->setContent(json_encode($data));
    }

    /**
     * Create a new plain text response.
     *
     * @param string $text
     * @return self
     */
    public static function text(string $text): self
    {
        return (new self())
            ->setContentType("text/plain")
            ->setContent($text);
    }

    /**
     * Create a new redirect response.
     *
     * @param string $url
     * @param integer $status
     * @return self
     */
    public static function redirect(string $url, int $status = 302): self
    {
        return (new self())
            ->setStatus($status)
            ->setHeader("Location", $url);
    }

    /**
     * Get the response HTTP status code.
     *
     * @return integer
     */
    public function status(): int
    {
        return $this->status;
    }

    /**
     * Set the response HTTP status code.
     *
     * @param integer $status
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get response HTTP headers.
     *
     * @return array<string, string>
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * Set HTTP header `$header` to `value`. 
     *
     * @param string $header
     * @param string $value
     * @return self
     */
    public function setHeader(string $header, string $value): self
    {
        $this->headers[strtolower($header)] = $value;
        return $this;
    }

    /**
     * Remove HTTP header `$header` from the response.
     *
     * @param string $header
     * @return self
     */
    public function removeHeader(string $header): self
    {
        unset($this->headers[strtolower($header)]);
        return $this;
    }

    /**
     * Set the `"Content-Type"` header for the response.
     *
     * @param string $contentType
     * @return self
     */
    public function setContentType(string $contentType): self
    {
        $this->setHeader("Content-Type", $contentType);
        return $this;
    }

    /**
     * Get the response content.
     *
     * @return string|null
     */
    public function content(): ?string
    {
        return $this->content;
    }

    /**
     * Set the response content.
     *
     * @param string|null $content
     * @return self
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }
}
