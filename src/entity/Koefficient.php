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
 * Коэффициент.
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class Koefficient extends Entity
{
    /** @var string */
    public $name;

    /** @var ?float */
    public $value;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['name', 'value'], 'trim'],
            [['name', 'value'], 'required'],

            ['value', 'number'],
            ['value', 'filter', 'filter' => 'floatval']
        ];
    }
}
