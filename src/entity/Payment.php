<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 24.04.21 23:44:23
 */

declare(strict_types = 1);
namespace dicr\renins\entity;

use dicr\renins\Entity;

use function is_string;

/**
 * Платеж
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class Payment extends Entity
{
    /** @var int Номер */
    public $number;

    /**
     * @var string Дата ($yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $date;

    /** @var ?float */
    public $sum;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['number', 'date', 'sum'], 'trim'],

            ['number', 'integer', 'min' => 1],
            ['number', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['date', 'required'],
            ['date', 'filter', 'filter' => static fn($val) => self::parseDate($val), 'skipOnEmpty' => true],

            ['sum', 'required'],
            ['sum', 'number', 'min' => 0],
            ['sum', 'filter', 'filter' => 'floatval', 'skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesFromJson(): array
    {
        return [
            'date' => static fn($val) => is_string($val) ? self::parseDate($val) : $val
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson(): array
    {
        return [
            'date' => static fn($val) => is_string($val) ? self::formatDate($val) : $val
        ];
    }
}
