<?php

declare(strict_types=1);

namespace SergeyZatulivetrov\TinkoffAcquiring;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use SergeyZatulivetrov\TinkoffAcquiring\Contracts\ClientContract;
use SergeyZatulivetrov\TinkoffAcquiring\Contracts\DataContract;
use SergeyZatulivetrov\TinkoffAcquiring\Data\AddCustomer;
use SergeyZatulivetrov\TinkoffAcquiring\Data\Cancel;
use SergeyZatulivetrov\TinkoffAcquiring\Data\Charge;
use SergeyZatulivetrov\TinkoffAcquiring\Data\Confirm;
use SergeyZatulivetrov\TinkoffAcquiring\Data\FinishAuthorize;
use SergeyZatulivetrov\TinkoffAcquiring\Data\GetCardList;
use SergeyZatulivetrov\TinkoffAcquiring\Data\GetCustomer;
use SergeyZatulivetrov\TinkoffAcquiring\Data\GetState;
use SergeyZatulivetrov\TinkoffAcquiring\Data\Init;
use SergeyZatulivetrov\TinkoffAcquiring\Data\RemoveCard;
use SergeyZatulivetrov\TinkoffAcquiring\Data\RemoveCustomer;
use SergeyZatulivetrov\TinkoffAcquiring\Data\Resend;
use SergeyZatulivetrov\TinkoffAcquiring\Data\SendClosingReceipt;
use SergeyZatulivetrov\TinkoffAcquiring\Data\Submit3DSAuthorization;
use SergeyZatulivetrov\TinkoffAcquiring\Data\CreateBeneficiaries;


class Client implements ClientContract
{
    public const API_URL = 'https://securepay.tinkoff.ru/v2/';
    public const API_URL_T_ID = 'https://secured-openapi.tbank.ru/api/v1/';


    public function init(Init $data): array
    {
        return $this->execute('Init', $data);
    }

    public function finishAuthorize(FinishAuthorize $data): array
    {
        return $this->execute('FinishAuthorize', $data);
    }

    public function confirm(Confirm $data): array
    {
        return $this->execute('Confirm', $data);
    }

    public function cancel(Cancel $data): array
    {
        return $this->execute('Cancel', $data);
    }

    public function getState(GetState $data): array
    {
        return $this->execute('GetState', $data);
    }

    public function resend(Resend $data): array
    {
        return $this->execute('Resend', $data);
    }

    public function submit3DSAuthorization(Submit3DSAuthorization $data): array
    {
        return $this->execute('Submit3DSAuthorization', $data, 'application/x-www-form-urlencoded');
    }

    public function sendClosingReceipt(SendClosingReceipt $data): array
    {
        return $this->execute('SendClosingReceipt', $data);
    }

    public function charge(Charge $data): array
    {
        return $this->execute('Charge', $data);
    }

    public function addCustomer(AddCustomer $data): array
    {
        return $this->execute('AddCustomer', $data);
    }

    public function getCustomer(GetCustomer $data): array
    {
        return $this->execute('GetCustomer', $data);
    }

    public function removeCustomer(RemoveCustomer $data): array
    {
        return $this->execute('RemoveCustomer', $data);
    }

    public function getCardList(GetCardList $data): array
    {
        return $this->execute('GetCardList', $data);
    }

    public function removeCard(RemoveCard $data): array
    {
        return $this->execute('RemoveCard', $data);
    }

    public function createBeneficiaries(CreateBeneficiaries $data): array
    {
        return $this->executeTID('nominal-accounts/beneficiaries', $data);
    }

    private function execute(string $action, DataContract $data, string $contentType = 'application/json'): array
    {
        $client = new HttpClient();

        $response = $client->request(
            'POST',
            self::API_URL . $action,
            [
                RequestOptions::HEADERS => [
                    'Content-Type' => $contentType,
                ],
                RequestOptions::BODY => json_encode($data->toArray()),
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    private function executeTID(string $action, DataContract $data, string $contentType = 'application/json', string $token = 'token', string $cert = '/path/to/openyes.crt.pem', $ssl_key = '/path/to/openyes.key.pem'): array
    {
        $client = new HttpClient();

        $response = $client->request(
            'POST',
            self::API_URL_T_ID . $action,
            [
                RequestOptions::HEADERS => [
                    'Content-Type' => $contentType,
                    'Authorization' => 'Bearer ' . $token
                ],
                RequestOptions::BODY => json_encode($data->toArray()),
                RequestOptions::CERT => $cert,
                RequestOptions::SSL_KEY => $ssl_key
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

}
