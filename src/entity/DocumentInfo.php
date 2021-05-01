<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 01.05.21 05:59:03
 */

declare(strict_types = 1);
namespace dicr\renins\entity;

use dicr\renins\Entity;

use function is_string;

/**
 * Документ
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class DocumentInfo extends Entity
{
    /** @var string Тип документа */
    public $type;

    /** @var ?string Серия */
    public $series;

    /** @var string Номер */
    public $number;

    /** @var string Кем выдан */
    public $placeOfIssue;

    /**
     * @var string Дата выдачи $yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $dateOfIssue;

    /** @var ?string Код подразделения */
    public $kodPodrazd;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['type', 'series', 'number', 'placeOfIssue', 'dateOfIssue', 'kodPodrazd'], 'trim'],

            [['type', 'number', 'placeOfIssue', 'dateOfIssue'], 'default'],

            ['dateOfIssue', 'trim'],
            ['dateOfIssue', 'filter', 'filter' => static fn($val) => self::parseDate($val), 'skipOnEmpty' => true],
            ['dateOfIssue', 'datetime', 'format' => 'php:Y-m-d'],

            [['series', 'kodPodrazd'], 'default']
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesFromJson(): array
    {
        return [
            'dateOfIssue' => static fn($val) => is_string($val) ? self::parseDate($val) : $val
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson(): array
    {
        return [
            'dateOfIssue' => static fn($val) => is_string($val) ? self::formatDate($val) : $val
        ];
    }
}
