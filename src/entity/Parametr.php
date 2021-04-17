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

/**
 * Параметр.
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class Parametr extends Entity
{
    /** @var string Название */
    public $name;

    /** @var ?string Код */
    public $code;

    /** @var string Тип */
    public $type;

    /** @var ?string */
    public $stringValue;

    /** @var ?float */
    public $decimalValue;

    /**
     * @var ?string ($yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $dateValue;

    /** @var ?bool */
    public $boolValue;

    /** @var ?int */
    public $intValue;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['name', 'code', 'type', 'stringValue', 'decimalValue', 'dateValue', 'intValue'], 'trim'],

            [['name', 'type'], 'required'],

            [['code', 'stringValue', 'decimalValue', 'dateValue', 'boolValue', 'intValue'], 'default'],

            ['decimalValue', 'number'],
            ['decimalValue', 'filter', 'filter' => 'floatval', 'skipOnEmpty' => true],

            ['dateValue', 'date', 'format' => 'php:Y-m-d\TH:i:s.p\Z'],

            ['boolValue', 'boolean'],
            ['boolValue', 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            ['intValue', 'integer'],
            ['intValue', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true]
        ];
    }
}
