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
 * Адрес.
 */
class AddressInfo extends Entity
{
    /** @var string Страна */
    public $country;

    /** @var string индекс */
    public $postIndex;

    /** @var string Регион. Для получения справочника регионов пользуйтесь методом /dictionary */
    public $region;

    /** @var ?string Район региона */
    public $district;

    /** @var ?string Населённый пункт */
    public $locality;

    /** @var ?string Код населённого пункта КЛАДР */
    public $localityCodeKLADR;

    /** @var ?string улица */
    public $street;

    /** @var ?string Дом */
    public $houseNumber;

    /** @var ?string Корпус */
    public $houseCorps;

    /** @var ?string Строение */
    public $houseBuilding;

    /** @var ?string Квартира */
    public $flat;

    /** @var string Адрес строкой */
    public $addressText;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['country', 'postIndex', 'region', 'district', 'locality', 'localityCodeKLADR', 'street', 'houseNumber',
                'houseCorps', 'houseBuilding', 'flat', 'addressText'], 'trim'],

            [['country', 'postIndex', 'region', 'addressText'], 'required'],

            [['district', 'locality', 'localityCodeKLADR', 'street', 'houseNumber', 'houseCorps', 'houseBuilding',
                'flat'], 'default']
        ];
    }
}
