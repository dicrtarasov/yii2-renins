<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:05:44
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\renins\ReninsRequest;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\httpclient\Response;

use function base64_encode;

/**
 * Запрос токена.
 */
class TokenRequest extends ReninsRequest
{
    /** @var string авторизация при помощи consumerKey и consumerPassword */
    public const GRANT_TYPE_CREDENTIALS = 'client_credentials';

    /** @var string авторизация при помощи логина/пароля */
    public const GRANT_TYPE_PASSWORD = 'password';

    /** @var string[] типы авторизации */
    public const GRANT_TYPE = [
        self::GRANT_TYPE_CREDENTIALS,
        self::GRANT_TYPE_PASSWORD
    ];

    /** @var string тип авторизации */
    public $grantType;

    /** @var ?int время валидности токена (по-умолчанию 3600) */
    public $validityPeriod = 3600;

    /**
     * @inheritDoc
     */
    public function attributeFields(): array
    {
        return [
            'grantType' => 'grant_type',
            'validityPeriod' => 'validity_period'
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['grantType', 'default',
                'value' => fn() => $this->api->consumerKey !== null && $this->api->consumerSecret !== null ?
                    self::GRANT_TYPE_CREDENTIALS :
                    ($this->api->username !== null && $this->api->password !== null ? self::GRANT_TYPE_PASSWORD : null)
            ],
            ['grantType', 'required'],
            ['grantType', 'in', 'range' => self::GRANT_TYPE],
            ['grantType', function(string $attribute) {
                if ($this->grantType === self::GRANT_TYPE_CREDENTIALS) {
                    if ($this->api->consumerKey === null) {
                        $this->addError($attribute, 'Требуется consumerKey');
                    }

                    if ($this->api->consumerSecret === null) {
                        $this->addError($attribute, 'Требуется consumerSecret');
                    }
                } elseif ($this->grantType === self::GRANT_TYPE_PASSWORD) {
                    if ($this->api->username === null) {
                        $this->addError($attribute, 'Требуется username');
                    }

                    if ($this->api->password === null) {
                        $this->addError($attribute, 'Требуется password');
                    }
                }
            }],

            ['validityPeriod', 'default', 'value' => 3600],
            ['validityPeriod', 'integer', 'min' => 1],
            ['validityPeriod', 'filter', 'filter' => 'intval']
        ];
    }

    /**
     * @inheritDoc
     */
    protected function url(): string
    {
        return '/token';
    }

    /**
     * @inheritDoc
     */
    protected function headers(): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        if ($this->grantType === self::GRANT_TYPE_CREDENTIALS) {
            $headers['Authorization'] =
                'Basic ' . base64_encode($this->api->consumerKey . ':' . $this->api->consumerSecret);
        } elseif ($this->grantType === self::GRANT_TYPE_PASSWORD) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->api->username . ':' . $this->api->password);
        }

        return $headers;
    }

    /**
     * @inheritDoc
     */
    protected function data(): array
    {
        $data = $this->json;

        if ($this->grantType === self::GRANT_TYPE_PASSWORD) {
            $data['username'] = $this->api->username;
            $data['password'] = $this->api->password;
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    protected function httpRequest(): Request
    {
        $req = parent::httpRequest();
        $req->format = Client::FORMAT_URLENCODED;

        return $req;
    }

    /**
     * @inheritDoc
     */
    protected function response(Response $response): TokenResponse
    {
        return new TokenResponse([
            'json' => $response->data
        ]);
    }

    /**
     * @inheritDoc
     */
    public function send(): TokenResponse
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::send();
    }
}
