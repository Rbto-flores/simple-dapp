<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FireblocksService
{
    private $apiKey;
    private $httpClient;
    private $baseUrl;
    private $privateKey;

    public function __construct()
    {
        $this->apiKey = config('services.fireblocks.api_key');
        $this->baseUrl = config('services.fireblocks.base_url'); // prod o sandbox
        $this->privateKey = file_get_contents(storage_path('fireblocks/private_key.pem'));

        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 10.0,
        ]);
    }

    private function generateSignature(string $body, string $ts): string
    {
        $message = $ts . $body;
        openssl_sign($message, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    private function headers(string $body = '')
    {
        $ts = (string)(microtime(true) * 1000);

        return [
            'Authorization' => $this->apiKey,
            'X-Request-Id' => uniqid(),
            'X-Timestamp' => $ts,
            'Content-Type' => 'application/json',
            'X-Signature' => $this->generateSignature($body, $ts),
        ];
    }

    public function createVaultAccount(string $name)
    {
        $body = json_encode(['name' => $name]);

        $response = $this->httpClient->post('/vault/accounts', [
            'headers' => $this->headers($body),
            'body' => $body,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function createVaultAsset(string $vaultId, string $asset)
    {
        $response = $this->httpClient->post("/vault/accounts/$vaultId/$asset", [
            'headers' => $this->headers(),
        ]);

        return json_decode($response->getBody(), true);
    }

    public function transfer(string $fromVaultId, string $toAddress, string $amount, string $asset = 'SOL')
    {
        $body = json_encode([
            'assetId' => $asset,
            'source' => [
                'type' => 'VAULT_ACCOUNT',
                'id' => $fromVaultId
            ],
            'destination' => [
                'type' => 'ONE_TIME_ADDRESS',
                'oneTimeAddress' => $toAddress
            ],
            'amount' => $amount,
            'note' => 'Transferencia desde Laravel',
        ]);

        $response = $this->httpClient->post('/transactions', [
            'headers' => $this->headers($body),
            'body' => $body,
        ]);

        return json_decode($response->getBody(), true);
    }
}
