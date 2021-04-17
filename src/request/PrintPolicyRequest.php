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
 * Команда оформлению и печати полиса страхования
 */
class PrintPolicyRequest extends ReninsRequest
{
    /** @var string */
    public const TYPE_DRAFT = 'Черновик';

    /** @var string */
    public const TYPE_PRINT = 'Печать';

    /** @var string[] типы печати */
    public const TYPE = [
        self::TYPE_DRAFT, self::TYPE_PRINT
    ];

    /** @var string ID полиса который надо распечатать */
    public $calcID;

    /** @var string Тип запроса */
    public $type;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['calcID', 'trim'],
            ['calcID', 'required'],

            ['type', 'trim'],
            ['type', 'required'],
            ['type', 'in', 'range' => self::TYPE]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function url(): string
    {
        return '/IpotekaAPI/1.0.0/print';
    }

    /**
     * @inheritDoc
     */
    protected function response(Response $response): PrintPolicyResponse
    {
        return new PrintPolicyResponse([
            'json' => $response->data
        ]);
    }

    /**
     * @inheritDoc
     */
    public function send(): PrintPolicyResponse
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::send();
    }
}
