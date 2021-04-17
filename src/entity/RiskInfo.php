<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 12:58:04
 */

declare(strict_types = 1);
namespace dicr\renins\entity;

use dicr\json\EntityValidator;
use dicr\renins\Entity;

use function array_merge;

/**
 * Информация о рисках.
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class RiskInfo extends Entity
{
    /** @var Risk[] */
    public $risks;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'risks' => [Risk::class]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['risks', 'required'],
            ['risks', EntityValidator::class]
        ];
    }
}
