<?php

namespace Punksolid\Doopla;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Doopla
{
    public const BASE_URI = 'https://doopla.mx/';
    const MOZILLA_AGENT = 'Mozilla/5.0 (X11; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/114.0';
    const INICIAR_SESION_URL = 'https://doopla.mx/iniciar-sesion';
    const BASE_URL = 'https://doopla.mx';

    public array $settings;

    private HttpClientInterface $client;

    private $cookie;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client->withOptions(options: [
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'User-Agent' => self::MOZILLA_AGENT,
                'accept' => 'application/json',
                'Origin' => self::BASE_URL,
                'Upgrade-Insecure-Requests' => '1',
                'Sec-Fetch-Dest' => 'document',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'same-origin',
                'TE' => 'trailers',
                'Sec-Fetch-User' => '?1',
            ],
        ]);
    }

    public function getSessionPuttingEmail()
    {
        $response = $this->client->request('POST', self::INICIAR_SESION_URL, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Referer' => self::INICIAR_SESION_URL,
            ],
            'body' => [
                'txtEmail' => <<<'EOF'
%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2%E2%80%A2
EOF,
                'email' => $this->settings['email'],
            ],
            'max_redirects' => 0,
        ]);

        $this->cookie = $response->getHeaders()['set-cookie'][0];

        return $response->getHeaders()['set-cookie'][0];
    }

    public function getBalance()
    {

        $response = $this->client->request('GET', 'https://doopla.mx/resumen-cuenta-inversionista', [
            'headers' => [
                'Cookie' => $this->cookie,
                'Sec-Fetch-Site' => 'cross-site',
            ],
        ]);

        $crawler = new Crawler($response->getContent());

        return $crawler->filter('.content-resume.text-center')
            ->eq(3)
            ->filter('p.text-primary')
            ->text();
    }

    public function setPassword(string $password): void
    {
        $this->settings['password'] = $password;
    }

    public function setEmail(string $email): void
    {
        $this->settings['email'] = $email;
    }

    public function login():void
    {
        $this->getSessionPuttingEmail();

        $this->client->request('POST', self::INICIAR_SESION_URL, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Referer' => self::INICIAR_SESION_URL,
                'Cookie' => $this->cookie,

            ],
            'body' => [
                'pw' => $this->settings['password'],
            ],
        ]);
    }
}
