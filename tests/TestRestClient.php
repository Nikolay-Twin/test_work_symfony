<?php
declare(strict_types=1);
namespace App\Tests;


use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class TestRestClient extends AbstractBrowser
{
    private array $headers = ['charset' => 'utf-8'];
    private string $method = Request::METHOD_GET;
    private string $host;
    private string $uri;

    /**
     * @param string $host
     * @return $this
     */
    public static function createClient(): self
    {
        return new static;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost(string $host): self
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @param string $headerName
     * @param string $headerValue
     * @return $this
     */
    public function withHeader(string $headerName, string $headerValue): self
    {
        $this->headers[$headerName] = $headerValue;
        return $this;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function withMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function withUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param string $uri
     * @return void
     */
    public function sendGet(string $uri): void
    {
        $this
            ->withMethod(Request::METHOD_GET)
            ->withUri($uri)
            ->execute();
    }

    /**
     * @param string $uri
     * @param string|null $data
     * @return void
     */
    public function sendPost(string $uri, string $data = null): void
    {
        $this
            ->withMethod(Request::METHOD_POST)
            ->withUri($uri)
            ->execute($data);
    }

    /**
     * @param string $uri
     * @param string|null $data
     * @return void
     */
    public function sendPut(string $uri, string $data = null): void
    {
        $this
            ->withMethod(Request::METHOD_PUT)
            ->withUri($uri)
            ->execute($data);
    }

    /**
     * @param string $uri
     * @param string|null $data
     * @return void
     */
    public function sendDelete(string $uri, string $data = null): void
    {
        $this
            ->withMethod(Request::METHOD_DELETE)
            ->withUri($uri)
            ->execute($data);
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param object $request
     * @return Response
     */
    protected function doRequest(object $request): Response
    {
        return $this->response;
    }

    /**
     * @param string|null $data
     * @return void
     */
    private function execute(?string $data): void
    {
        $uri = $this->host . $this->uri;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, true);

        if (Request::METHOD_GET !== $this->method && !is_null($data)) {
            $this->headers[] = 'Content-Length: ' . strlen($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);

        if (false === ($response = curl_exec($curl))) {
            throw new BadRequestException((string)curl_errno($curl));
        }

        $this->response = new Response($response, curl_getinfo($curl, CURLINFO_HTTP_CODE));

    }
}
