<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 25.04.21 03:03:59
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

    /** @var Errors */
    public $errors;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'policy' => Policy::class,
            'errors' => Errors::class
        ]);
    }
}
