<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 24.04.21 23:22:25
 */

declare(strict_types = 1);
namespace dicr\renins;

use dicr\json\JsonEntity;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Объект данных.
 */
abstract class Entity extends JsonEntity
{
    /**
     * Форматирование даты из формата API.
     *
     * @param ?string $val
     * @return ?string
     * @throws InvalidConfigException
     */
    public static function parseDate(?string $val): ?string
    {
        return $val === null || $val === '' ? null :
            Yii::$app->formatter->asDate($val, 'php:Y-m-d');
    }

    /**
     * @inheritDoc
     */
    public function attributeFields(): array
    {
        // отключаем преобразование названий полей
        return [];
    }

    /**
     * Форматирует дату в формат API.
     *
     * @param ?string $val
     * @return ?string
     * @throws InvalidConfigException
     */
    public static function formatDate(?string $val): ?string
    {
        return $val === null || $val === '' ? null :
            Yii::$app->formatter->asDate($val, 'php:Y-m-d') . 'T00:00:00.000Z';
    }

    /**
     * Парсит булево значение.
     *
     * @param ?string $val
     * @return ?bool
     */
    public static function parseBool(?string $val): ?bool
    {
        if ($val === 'true') {
            return true;
        }

        if ($val === 'false') {
            return false;
        }

        return null;
    }

    /**
     * Форматирует булево значение.
     *
     * @param ?bool $val
     * @return ?string
     */
    public static function formatBool(?bool $val): ?string
    {
        if ($val === null) {
            return null;
        }

        return $val ? 'true' : 'false';
    }
}
