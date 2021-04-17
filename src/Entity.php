<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 12:58:04
 */

declare(strict_types = 1);
namespace dicr\renins;

use dicr\json\JsonEntity;

/**
 * Объект данных.
 */
abstract class Entity extends JsonEntity
{
    /**
     * @inheritDoc
     */
    public function attributeFields(): array
    {
        // отключаем преобразование названий полей
        return [];
    }
}
