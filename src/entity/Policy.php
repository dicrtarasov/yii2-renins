<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 24.04.21 23:46:56
 */

declare(strict_types = 1);
namespace dicr\renins\entity;

use dicr\json\EntityValidator;
use dicr\renins\Entity;

use function array_merge;

/**
 * Class Policy
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class Policy extends Entity
{
    /** @var ?string Компания страхования */
    public $insCompanyName;

    /** @var ProductInfo */
    public $product;

    /** @var ?string Номер договора */
    public $number;

    /** @var ?string Код расчёта */
    public $calcID;

    /**
     * @var string Дата полиса ($yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $date;

    /**
     * @var ?string Дата начала срока страхования ($yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $dateBeg;

    /**
     * @var ?string Дата окончания срока страхования ($yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $dateEnd;

    /** @var InsurantInfo Страхователь */
    public $insurant;

    /** @var InsuranceObjects Объекты страхования */
    public $insuranceObjects;

    /** @var ?int Страховая премия итого */
    public $insPremTotal;

    /**
     * @var ?string Дата расчета ($yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $dateCalc;

    /**
     * @var ?string Тип оплаты
     */
    public $paymentType;

    /** @var ?PaymentsPlan планируемые платежи */
    public $paymentsPlan;

    /** @var ?PaymentsPlan фактические платежи */
    public $paymentsFact;

    /** @var ?string */
    public $ID;

    /** @var ?bool */
    public $pechatNaBlanke;

    /** @var ?bool */
    public $skidkaAvVProc;

    /** @var ?float */
    public $discountUnderwriter;

    /** @var ?bool */
    public $clientWithoutLoss;

    /** @var ?bool */
    public $foulOfInsurance;

    /** @var ?string тип документа страхователя */
    public $insurantDocType;

    /** @var ?PointOfSale Точка продаж */
    public $pointOfSale;

    /** @var ?UserInfo Информация о пользователе */
    public $userInfo;

    /** @var ?Parameters */
    public $parameters;

    /** @var string ("RUR") */
    public $currCode = 'RUR';

    /** @var ?bool */
    public $onlinePayment;

    // --- в ответе --------------------------

    /** @var ?string */
    public $state;

    /** @var ?bool */
    public $prolongation;

    /** @var ?int */
    public $internalID;

    /** @var ?int */
    public $discountAV;

    /** @var ?bool */
    public $epolicy;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'product' => ProductInfo::class,
            'insurant' => InsurantInfo::class,
            'insuranceObjects' => InsuranceObjects::class,
            'pointOfSale' => PointOfSale::class,
            'userInfo' => UserInfo::class,
            'parameters' => Parameters::class,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['insCompanyName', 'number', 'calcID', 'date', 'dateBeg', 'dateEnd', 'insPremTotal', 'dateCalc',
                'paymentType', 'ID', 'discountUnderwriter', 'insurantDocType', 'currCode'], 'trim'],

            [['insCompanyName', 'number', 'calcID', 'dateBeg', 'dateEnd', 'insPremTotal', 'dateCalc', 'paymentType',
                'paymentsPlan', 'paymentsFact', 'ID', 'pechatNaBlanke', 'skidkaAvVProc', 'discountUnderwriter',
                'clientWithoutLoss', 'foulOfInsurance', 'insurantDocType', 'pointOfSale', 'userInfo', 'parameters',
                'onlinePayment'], 'default'],

            [['product', 'date', 'insurant', 'insuranceObjects', 'currCode'], 'required'],

            [['product', 'insurant', 'insuranceObjects', 'paymentsPlan', 'paymentsFact', 'pointOfSale', 'userInfo',
                'parameters'], EntityValidator::class],

            [['date', 'dateBeg', 'dateEnd', 'dateCalc'], 'filter',
                'filter' => static fn($val) => self::parseDate($val), 'skipOnEmpty' => true],

            [['insPremTotal', 'discountUnderwriter'], 'number'],
            [['insPremTotal', 'discountUnderwriter'], 'filter', 'filter' => 'floatval', 'skipOnEmpty' => true],

            [['pechatNaBlanke', 'skidkaAvVProc', 'clientWithoutLoss', 'foulOfInsurance', 'onlinePayment'], 'boolean'],
            [['pechatNaBlanke', 'skidkaAvVProc', 'clientWithoutLoss', 'foulOfInsurance', 'onlinePayment'], 'filter',
                'filter' => 'boolval', 'skipOnEmpty' => true]
        ];
    }
}
