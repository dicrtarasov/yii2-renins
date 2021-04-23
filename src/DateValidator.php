<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 24.04.21 04:29:43
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
        $val = $model->{$attribute};

        $model->{$attribute} = $val === null || $val === '' ? null :
            Yii::$app->formatter->asDate($val, 'php:Y-m-d') . 'T00:00:00.000Z';
    }
}
