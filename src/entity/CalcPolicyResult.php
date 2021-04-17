<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 12:58:04
 */

declare(strict_types = 1);
namespace dicr\renins\entity;

use dicr\renins\Entity;

use function array_merge;

/**
 * Результат расчета полиса.
 */
class CalcPolicyResult extends Entity
{
    /** @var string */
    public $url;

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
}
