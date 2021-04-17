<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:05:44
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\json\EntityValidator;
use dicr\renins\entity\Policy;
use dicr\renins\ReninsRequest;
use yii\httpclient\Response;

use function array_merge;

/**
 * Команда по сохранению данных из анкеты клиента для оформления полиса страхования
 */
class ImportPolicyRequest extends ReninsRequest
{
    /** @var Policy */
    public $policy;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'policy' => Policy::class
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['policy', 'required'],
            ['policy', EntityValidator::class]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function url(): string
    {
        return '/IpotekaAPI/1.0.0/import';
    }

    /**
     * @inheritDoc
     */
    protected function response(Response $response): ImportPolicyResponse
    {
        return new ImportPolicyResponse([
            'json' => $response->data
        ]);
    }

    /**
     * @inheritDoc
     */
    public function send(): ImportPolicyResponse
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::send();
    }
}
