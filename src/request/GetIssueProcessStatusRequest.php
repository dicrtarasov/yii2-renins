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
use yii\httpclient\Response;

/**
 * Команда получить статус оплаты договора с онлайн-оплатой.
 */
class GetIssueProcessStatusRequest extends ReninsRequest
{
    /**
     * @var string ID полиса статус оплаты которого проверяем.
     * Можно получить после вызова метода расчета; значение для него берётся из описания сервиса импорта
     * соответствующего продукта.
     */
    public $policyID;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['policyID', 'trim'],
            ['policyID', 'required']
        ];
    }

    /**
     * @inheritDoc
     */
    protected function url(): string
    {
        return '/IpotekaAPI/1.0.0/getIssueProcessStatus';
    }

    /**
     * @inheritDoc
     */
    protected function response(Response $response): GetIssueProcessStatusResponse
    {
        return new GetIssueProcessStatusResponse([
            'json' => $response->data
        ]);
    }

    /**
     * @inheritDoc
     */
    public function send(): GetIssueProcessStatusResponse
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::send();
    }
}
