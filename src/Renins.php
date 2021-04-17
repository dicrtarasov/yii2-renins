<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:06:23
 */

declare(strict_types = 1);
namespace dicr\renins;

use dicr\renins\request\TokenRequest;
use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\caching\CacheInterface;
use yii\di\Instance;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;

/**
 * Renins API.
 *
 * @property-read Client $httpClient
 * @property-read string $token
 *
 * @link http://confluence.teamss.ru/pages/viewpage.action?pageId=18809309
 */
class Renins extends Component
{
    /** @var string */
    public const URL_API = 'https://apigateway.renins.com';

    /** @var string */
    public $url = self::URL_API;

    // --- авторизация методом API KEY

    /** @var ?string */
    public $apiKey;

    // --- для получения токена из consumerKey:consumerSecret

    /** @var ?string */
    public $consumerKey;

    /** @var ?string */
    public $consumerSecret;

    // --- для получения токена из username:password

    /** @var ?string */
    public $username;

    /** @var ?string */
    public $password;

    /** @var CacheInterface кэш для хранения токена */
    public $cache = 'cache';

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        if (empty($this->url)) {
            throw new InvalidConfigException('url');
        }

        $this->cache = Instance::ensure($this->cache, CacheInterface::class);
    }

    /**
     * HTTP Client
     *
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return new Client([
            'transport' => CurlTransport::class,
            'baseUrl' => $this->url,
            'requestConfig' => [
                'format' => Client::FORMAT_JSON,
                'options' => [
                    CURLOPT_ENCODING => '',
                ]
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ]
        ]);
    }

    /**
     * Запрос.
     *
     * @param array $config
     * @return ReninsRequest
     * @throws InvalidConfigException
     */
    public function request(array $config): ReninsRequest
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::createObject($config, [$this]);
    }

    /**
     * Токен доступа.
     *
     * @return string
     * @throws Exception
     */
    public function getToken(): string
    {
        $token = $this->cache->get(__METHOD__);
        if ($token === false) {
            /** @var TokenRequest $req */
            $req = $this->request([
                'class' => TokenRequest::class
            ]);

            $res = $req->send();
            $token = $res->accessToken;
            $this->cache->set(__CLASS__, $token, $res->expiresIn);
        }

        return $token;
    }
}

