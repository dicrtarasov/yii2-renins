<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 25.04.21 02:15:13
 */

declare(strict_types = 1);
namespace dicr\renins\entity;

use dicr\json\EntityValidator;
use dicr\renins\Entity;

use function array_merge;
use function is_string;

/**
 * Персона.
 */
class PhysicalSubject extends Entity
{
    /** @var ?int Внутренний идентификатор */
    public $internalID;

    /** @var string Фамилия */
    public $lastName;

    /** @var string Имя */
    public $firstName;

    /** @var ?string Отчество */
    public $middleName;

    /** @var ?string Фамилия на транслите */
    public $lastNameLat;

    /** @var ?string Имя на транслите */
    public $firstNameLat;

    /** @var ?string Отчество на транслите */
    public $middleNameLat;

    /** @var ?string ИНН */
    public $inn;

    /** @var ?string СНИЛС */
    public $snils;

    /**
     * @var string Дата рождения ($yyyy-MM-dd'T'HH:mm:ss.SSS'Z')
     * pattern: \d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)
     */
    public $birthDate;

    /** @var ?string */
    public $email;

    /** @var string Телефон */
    public $phone;

    /** @var string Пол */
    public $sex;

    /** @var string Гражданство */
    public $citizenship;

    /** @var ?DocumentInfo */
    public $passport;

    /** @var ?DocumentInfo */
    public $document;

    /** @var AddressInfo */
    public $factAddress;

    /** @var ?AddressInfo */
    public $residenceAddress;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'passport' => DocumentInfo::class,
            'document' => DocumentInfo::class,
            'factAddress' => AddressInfo::class,
            'residenceAddress' => AddressInfo::class
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['internalID', 'lastName', 'firstName', 'middleName', 'lastNameLat', 'firstNameLat', 'middleNameLat',
                'inn', 'snils', 'birthDate', 'email', 'phone', 'sex', 'citizenship'], 'trim'],

            [['internalID', 'middleName', 'lastNameLat', 'firstNameLat', 'middleNameLat', 'inn', 'snils', 'email',
                'passport', 'document', 'residenceAddress'], 'default'],

            [['lastName', 'firstName', 'birthDate', 'phone', 'sex', 'citizenship', 'factAddress'], 'default'],

            [['passport', 'document', 'factAddress', 'residenceAddress'], EntityValidator::class],

            ['email', 'email'],

            ['birthDate', 'filter', 'filter' => static fn($val) => self::parseDate($val), 'skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesFromJson(): array
    {
        return [
            'birthDate' => static fn($val) => is_string($val) ? self::parseDate($val) : $val
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson(): array
    {
        return [
            'birthDate' => static fn($val) => is_string($val) ? self::formatDate($val) : $val
        ];
    }
}

