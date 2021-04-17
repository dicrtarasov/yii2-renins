<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:05:53
 */

declare(strict_types = 1);
namespace dicr\renins;

use dicr\helper\Log;
use dicr\renins\entity\Error;
use dicr\validate\ValidateException;
use yii\base\Exception;
use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * Абстрактный запрос.
 */
abstract class ReninsRequest extends Entity
{
    /** @var Renins */
    protected $api;

    /**
     * ReninsRequest constructor.
     *
     * @param Renins $api
     * @param array $config
     */
    public function __construct(Renins $api, array $config = [])
    {
        $this->api = $api;

        parent::__construct($config);
    }

    /**
     * URL запроса.
     *
     * @return string
     * @throws Exception
     */
    abstract protected function url(): string;

    /**
     * Данные запроса.
     *
     * @return array
     */
    protected function data(): array
    {
        return $this->json;
    }

    /**
     * Заголовки запроса.
     *
     * @return array
     */
    protected function headers(): array
    {
        return [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->api->token
        ];
    }

    /**
     * HTTP-запрос.
     *
     * @return Request
     * @throws Exception
     */
    protected function httpRequest(): Request
    {
        return $this->api->httpClient
            ->post($this->url(), $this->data(), $this->headers());
    }

    /**
     * Данные ответа.
     *
     * @param Response $response
     * @return ReninsResponse
     * @throws Exception
     */
    abstract protected function response(Response $response): ReninsResponse;

    /**
     * Отправка запроса.
     *
     * @return ReninsResponse
     * @throws Exception
     */
    public function send(): ReninsResponse
    {
        if (! $this->validate()) {
            throw new ValidateException($this);
        }

        $req = $this->httpRequest();
        Log::debug('Запрос: ' . $req->toString());

        $res = $req->send();
        Log::debug('Ответ: ' . $res->toString());

        $ret = $this->response($res);

        // ошибки авторизации
        if (! empty($ret->fault)) {
            throw new Exception($ret->fault->description);
        }

        // какие-то ошибки
        if (! empty($ret->errorDescription)) {
            throw new Exception($ret->errorDescription);
        }

        // наркоманские ошибки
        if (! empty($ret->errors)) {
            throw new Exception(implode('; ', array_map(
                static fn(Error $e) => $e->detailMessage ?: $e->message,
                $ret->errors->errors
            )));
        }

        // последний приоритет - http code
        if (! $res->isOk) {
            throw new Exception('HTTP-error: ' . $res->statusCode);
        }

        return $ret;
    }
}
