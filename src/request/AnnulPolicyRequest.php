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
 * Команда по аннулированию полиса страхования.
 */
class AnnulPolicyRequest extends ReninsRequest
{
    /** @var string */
    public const REASON_PRINT = 'Печать';

    /** @var string */
    public const REASON_DRAFT = 'Черновик';

    /** @var string[] */
    public const REASON = [
        self::REASON_DRAFT, self::REASON_PRINT
    ];

    /**
     * @var string Код расчёта,
     * calcID может быть получен из запросов save, issue
     */
    public $calcID;

    /** @var string Причина аннулирования */
    public $reason;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['calcID', 'trim'],
            ['calcID', 'required'],

            ['reason', 'trim'],
            ['reason', 'required'],
            ['reason', 'in', 'range' => self::REASON]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function url(): string
    {
        return '/IpotekaAPI/1.0.0/cancel';
    }

    /**
     * @inheritDoc
     */
    protected function response(Response $response): AnnulPolicyResponse
    {
        return new AnnulPolicyResponse([
            'json' => $response->data
        ]);
    }

    /**
     * @inheritDoc
     */
    public function send(): AnnulPolicyResponse
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::send();
    }
}

