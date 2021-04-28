<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 28.04.21 15:23:09
 */

declare(strict_types = 1);
namespace dicr\renins\entity;

use dicr\renins\Entity;
use yii\base\InvalidConfigException;

use function is_bool;
use function is_string;

/**
 * Параметр.
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class Parametr extends Entity
{
    /** @var string */
    public const TYPE_STRING = 'Строка';

    /** @var string */
    public const TYPE_DATE = 'Дата';

    /** @var string */
    public const TYPE_INT = 'Целое';

    /** @var string */
    public const TYPE_DECIMAL = 'Вещественный';

    /** @var string */
    public const TYPE_BOOL = 'Логический';

    /** @var string[] */
    public const TYPE = [
        self::TYPE_STRING, self::TYPE_DATE, self::TYPE_INT, self::TYPE_DECIMAL, self::TYPE_BOOL
    ];

    /** @var string Название */
    public $name;

    /** @var ?string Код */
    public $code;

    /** @var string Тип */
    public $type;

    /** @var ?string */
    public $stringValue;

    /**
     * @var ?string ($yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $dateValue;

    /** @var ?int */
    public $intValue;

    /** @var ?float */
    public $decimalValue;

    /** @var ?bool */
    public $boolValue;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],

            ['code', 'trim'],
            ['code', 'required'],

            ['type', 'required'],
            ['type', 'in', 'range' => self::TYPE],

            ['stringValue', 'required', 'when' => fn() => $this->type === self::TYPE_STRING],
            ['stringValue', 'string'],

            ['dateValue', 'required', 'when' => fn() => $this->type === self::TYPE_DATE],
            ['dateValue', 'filter', 'filter' => static fn($val) => self::parseDate($val), 'skipOnEmpty' => true],
            ['dateValue', 'date', 'format' => 'php:Y-m-d'],

            ['intValue', 'required', 'when' => fn() => $this->type === self::TYPE_INT],
            ['intValue', 'integer'],
            ['intValue', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['decimalValue', 'required', 'when' => fn() => $this->type === self::TYPE_DECIMAL],
            ['decimalValue', 'number'],
            ['decimalValue', 'filter', 'filter' => 'floatval', 'skipOnEmpty' => true],

            ['boolValue', 'required', 'when' => fn() => $this->type === self::TYPE_BOOL],
            ['boolValue', 'boolean'],
            ['boolValue', 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesFromJson(): array
    {
        return [
            'dateValue' => static fn($val) => is_string($val) ? self::parseDate($val) : $val,
            'boolValue' => static fn($val) => is_string($val) ? self::parseBool($val) : $val
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson(): array
    {
        return [
            'dateValue' => static fn($val) => is_string($val) ? self::formatDate($val) : $val,
            'boolValue' => static fn($val) => is_bool($val) ? self::formatBool($val) : $val
        ];
    }

    /**
     * Строковый параметр.
     *
     * @param string $name
     * @param string $code
     * @param string $value
     * @return static
     */
    public static function stringParam(string $name, string $code, string $value): self
    {
        return new self([
            'name' => $name,
            'code' => $code,
            'type' => self::TYPE_STRING,
            'stringValue' => $value
        ]);
    }

    /**
     * Дата-параметр.
     *
     * @param string $name
     * @param string $code
     * @param string $value
     * @return static
     * @throws InvalidConfigException
     */
    public static function dateParam(string $name, string $code, string $value): self
    {
        return new self([
            'name' => $name,
            'code' => $code,
            'type' => self::TYPE_DATE,
            'dateValue' => self::parseDate($value)
        ]);
    }

    /**
     * Целый параметр.
     *
     * @param string $name
     * @param string $code
     * @param int $value
     * @return static
     */
    public static function intParam(string $name, string $code, int $value): self
    {
        return new self([
            'name' => $name,
            'code' => $code,
            'type' => self::TYPE_INT,
            'intValue' => $value
        ]);
    }

    /**
     * Вещественный параметр.
     *
     * @param string $name
     * @param string $code
     * @param float $value
     * @return static
     */
    public static function decimalParam(string $name, string $code, float $value): self
    {
        return new self([
            'name' => $name,
            'code' => $code,
            'type' => self::TYPE_DECIMAL,
            'decimalValue' => $value
        ]);
    }

    /**
     * Логический параметр.
     *
     * @param string $name
     * @param string $code
     * @param bool $value
     * @return static
     */
    public static function boolParam(string $name, string $code, bool $value): self
    {
        return new self([
            'name' => $name,
            'code' => $code,
            'type' => self::TYPE_BOOL,
            'boolValue' => $value
        ]);
    }

    /**
     * Профессиональная деятельность.
     *
     * @param string $value
     * @return static
     */
    public static function profDeyatelnost(string $value): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('Профессиональная деятельность', 'dogovor.profDeyatelnost', $value);
    }

    /**
     * Пол.
     *
     * @param string $value
     * @return static
     */
    public static function pol(string $value): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('Пол', 'dogovor.zastr1.fl.pol', $value);
    }

    /**
     * БИК.
     *
     * @param string $value
     * @return static
     */
    public static function bik(string $value): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('БИК', 'dogovor.ipotechnDogovor.bank.subekt.bik', $value);
    }

    /**
     * Валюта.
     *
     * @param string $value
     * @return static
     */
    public static function currency(string $value = 'RUR'): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('Валюта (спр)', 'dogovor.ipotechnDogovor.currency.code', $value);
    }

    /**
     * Сумма кредита.
     *
     * @param float $value
     * @return static
     */
    public static function summaKredita(float $value): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::decimalParam('Сумма кредита', 'dogovor.ipotechnDogovor.summaKredita', $value);
    }

    /**
     * Год постройки.
     *
     * @param int $value
     * @return static
     */
    public static function godPostroiki(int $value): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::intParam('Год постройки', 'dogovor.godPostroiki', $value);
    }

    /**
     * Вид деятельности отсутствует в списке.
     *
     * @param bool $value
     * @return static
     */
    public static function vidDeyatOtsutstvuet(bool $value = true): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::boolParam(
            'Вид деятельности на текущем месте работы отсутствует в списке',
            'dogovor.vidDeyatOtsutstvuet',
            $value
        );
    }

    /**
     * Дата рождения.
     *
     * @param string $value
     * @return static
     * @throws InvalidConfigException
     */
    public static function dataRogd(string $value): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::dateParam('Дата рождения', 'dogovor.zastr1.fl.dataRogd', $value);
    }

    /**
     * Город выдачи кредита.
     *
     * @param string $value
     * @return static
     */
    public static function gorodVidachiKredita(string $value): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('Город выдачи кредита', 'dogovor.gorodVidachiKredita', $value);
    }

    /**
     * Дата.
     *
     * @param string $value
     * @return static
     * @throws InvalidConfigException
     */
    public static function data(string $value): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::dateParam('Дата', 'dogovor.ipotechnDogovor.data', $value);
    }

    /**
     * Статус занятости.
     *
     * @param string $value
     * @return static
     */
    public static function strahStatusZanatosti(string $value = 'Работник по найму'): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('Статус занятости Страхователя', 'dogovor.strahStatusZanatosti', $value);
    }

    /**
     * Застрахованный является Страхователем
     *
     * @param bool $value
     * @return static
     */
    public static function zastrahYavlstrah(bool $value = true): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::boolParam('Застрахованный является Страхователем', 'dogovor.zastrahYavlstrah', $value);
    }

    /**
     * Занимается экстремальными видами спорта из списка.
     *
     * @param string $value
     * @return static
     */
    public static function extremSport(string $value = 'нет'): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('Занимается экстремальными видами спорта из списка', 'dogovor.extremSport', $value);
    }

    /**
     * Наличие газосодержащих коммуникаций.
     *
     * @param bool $value
     * @return static
     */
    public static function nalichieGazKom(bool $value = false): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::boolParam('Наличие газосодержащих коммуникаций', 'dogovor.nalichieGazKom', $value);
    }

    /**
     * Вес.
     *
     * @param float $value
     * @return static
     */
    public static function ves(float $value = 80): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::decimalParam('Вес', 'dogovor.zastr1.medPokazateli.ves', $value);
    }

    /**
     * Нижнее давление.
     *
     * @param int $value
     * @return static
     */
    public static function nignDavlen(int $value = 80): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::intParam('Нижнее давление', 'dogovor.zastr1.medPokazateli.nignDavlen', $value);
    }

    /**
     * Верхнее давление.
     *
     * @param int $value
     * @return static
     */
    public static function verhnDavlen(int $value = 120): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::intParam('Верхнее давление', 'dogovor.zastr1.medPokazateli.verhnDavlen', $value);
    }

    /**
     * Рост.
     *
     * @param float $value
     * @return static
     */
    public static function rost(float $value = 180): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::decimalParam('Рост', 'dogovor.zastr1.medPokazateli.rost', $value);
    }

    /**
     * Условия труда связаны с повышенным риском для жизни и здоровья.
     *
     * @param bool $value
     * @return static
     */
    public static function usltrudaSvyazSRiskom(bool $value = false): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam(
            'Условия труда связаны с повышенным риском для жизни и здоровья',
            'dogovor.usltrudaSvyazSRiskom',
            $value ? 'да' : 'нет'
        );
    }

    /**
     * Вид скидки.
     *
     * @param string $value
     * @return static
     */
    public static function vidSkidki1(string $value = 'Не применяется'): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('Вид скидки', 'dogovor.vidSkidki1', $value);
    }

    /**
     * Размер скидки.
     *
     * @param float $value
     * @return static
     */
    public static function razmerSkidki1(float $value = 0): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::decimalParam('Размер скидки', 'dogovor.razmerSkidki1', $value);
    }

    /**
     * Профессия.
     *
     * @param string $value
     * @return static
     */
    public static function proffesia(string $value = 'офисный сотрудник'): self
    {
        /** @noinspection SpellCheckingInspection */
        return self::stringParam('Вид профессиональной деятельности', 'dogovor.proffesia', $value);
    }
}
