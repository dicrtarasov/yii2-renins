<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 25.04.21 01:02:24
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\renins\ReninsRequest;
use yii\httpclient\Response;

/**
 * Команда взять данные из справочника.
 */
class DictionaryRequest extends ReninsRequest
{
    /** @var string Банк */
    public const DICTIONARY_CODE_BAK = 'bank';

    /** @var string валюта */
    public const DICTIONARY_CODE_CUR = 'currency';

    /** @var string населенный пункт */
    public const DICTIONARY_CODE_NAS = 'nasPunkt';

    /** @var string район региона */
    public const DICTIONARY_CODE_RAN = 'raionRegiaona';

    /** @var string Регион */
    public const DICTIONARY_CODE_REG = 'region';

    /** @var string страна */
    public const DICTIONARY_CODE_STR = 'strana';

    /** @var string тип документа */
    public const DICTIONARY_CODE_DOC = 'tipdokumenta';

    /** @var string тип оплаты */
    public const DICTIONARY_CODE_OPL = 'tipoplati';

    /** @var string город выдачи кредита */
    public const DICTIONARY_CODE_GOR = 'SKgorodKredita';

    /** @var string риск условий труда */
    public const DICTIONARY_CODE_RIS = 'SKriskUslTruda';

    /** @var string спорт */
    public const DICTIONARY_CODE_SPT = 'SKsport';

    /** @var string виды профессиональной деятельности */
    public const DICTIONARY_CODE_PRF = 'SKprofDeyat';

    /** @var string профессиональная деятельность */
    public const DICTIONARY_CODE_PRD = 'SKprofDeyatelnost';

    /** @var string объект недвижимого имущества */
    public const DICTIONARY_CODE_IMH = 'SKImuschestvo';

    /** @var string статус занятости */
    public const DICTIONARY_CODE_ZAN = 'SKstrahStatusZanatosti';

    /** @var string цель кредита */
    public const DICTIONARY_CODE_CEL = 'SKcelKredita';

    /** @var string[] */
    public const DICTIONARY_CODE = [
        self::DICTIONARY_CODE_BAK,
        self::DICTIONARY_CODE_CUR,
        self::DICTIONARY_CODE_NAS,
        self::DICTIONARY_CODE_RAN,
        self::DICTIONARY_CODE_REG,
        self::DICTIONARY_CODE_STR,
        self::DICTIONARY_CODE_DOC,
        self::DICTIONARY_CODE_OPL,
        self::DICTIONARY_CODE_GOR,
        self::DICTIONARY_CODE_RIS,
        self::DICTIONARY_CODE_SPT,
        self::DICTIONARY_CODE_PRF,
        self::DICTIONARY_CODE_PRD,
        self::DICTIONARY_CODE_IMH,
        self::DICTIONARY_CODE_ZAN,
        self::DICTIONARY_CODE_CEL
    ];

    /** @var string */
    public const PRODUCT_KOR = 'Коробочная Ипотека';

    /** @var string */
    public const PRODUCT_ISB = 'Ипотека Сбербанк';

    /** @var string[] */
    public const PRODUCT = [
        self::PRODUCT_KOR,
        self::PRODUCT_ISB
    ];

    /** @var string */
    public $product;

    /** @var string */
    public $dictionaryCode;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['product', 'trim'],
            ['product', 'required'],
            ['product', 'in', 'range' => self::PRODUCT],

            ['dictionaryCode', 'trim'],
            ['dictionaryCode', 'required'],
            ['dictionaryCode', 'in', 'range' => self::DICTIONARY_CODE]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function url(): string
    {
        return '/IpotekaAPI/1.0.0/dictionary';
    }

    /**
     * @inheritDoc
     */
    protected function response(Response $response): DictionaryResponse
    {
        return new DictionaryResponse([
            'json' => $response->data
        ]);
    }

    /**
     * @inheritDoc
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function send(): DictionaryResponse
    {
        return parent::send();
    }
}
