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
 * Риск.
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class Risk extends Entity
{
    /** @var string Название */
    public $name;

    /** @var bool Страхуется */
    public $insured;

    /** @var int Страховая сумма */
    public $insSum;

    /** @var ?int Страховая премия */
    public $insPrem;

    /** @var ?string Валюта премии */
    public $insPremCurrCode;

    /** @var ?int Франшиза */
    public $fransiza;

    /** @var Koefficient[] */
    public $koefficients;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'koefficients' => [Koefficient::class]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['koefficients', 'required'],
            ['koefficients', EntityValidator::class]
        ];
    }
}
