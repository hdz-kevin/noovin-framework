<?php

namespace Noovin\Http;

use Noovin\Container\Container;

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
     * @return self
     */
    public function prepare(): self
    {
        if (is_null($this->content)) {
            $this->removeHeader("Content-Type");
            $this->removeHeader("Content-Length");
        } else {
            $this->setHeader("Content-Length", strlen($this->content));
        }

        return $this;
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

    public static function view(string $view, array $data = [], ?string $layout = null): self
    {
        $content = Container::resolve(\Noovin\App::class)
                    ->viewEngine
                    ->render($view, $data, $layout);

        return (new self())
            ->setContentType("text/html")
            ->setContent($content);
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
     * Get HTTP headers.
     * If a key is provided, returns the value for that key or null if it does not exist.
     *
     * @return array<string, string>
     */
    public function headers(?string $key = null): array|string|null
    {
        return is_null($key) ? $this->headers : ($this->headers[strtolower($key)] ?? null);
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
