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
 * Параметр словаря.
 */
class DictionaryParam extends Entity
{
    /** @var string */
    public $parameterCode;

    /** @var string */
    public $value;
}
