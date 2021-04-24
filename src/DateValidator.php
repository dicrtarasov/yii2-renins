<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 24.04.21 22:38:21
 */

declare(strict_types = 1);
namespace dicr\renins;

use Yii;
use yii\base\InvalidConfigException;
use yii\validators\Validator;

/**
 * Class DateValidator
 */
class DateValidator extends Validator
{
    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function validateAttribute($model, $attribute): void
    {
        $model->{$attribute} = self::formatValue($model->{$attribute});
    }

    /**
     * Форматирует значение.
     *
     * @param ?string $value
     * @return ?string
     * @throws InvalidConfigException
     */
    public static function formatValue(?string $value): ?string
    {
        return $value === null || $value === '' ? null :
            Yii::$app->formatter->asDate($value, 'php:Y-m-d') . 'T00:00:00.000Z';
    }
}
