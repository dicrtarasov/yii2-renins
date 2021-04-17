<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:05:53
 */

declare(strict_types = 1);
namespace dicr\renins;

use dicr\renins\entity\Errors;
use dicr\renins\entity\Fault;

/**
 * Ответ src.
 */
abstract class ReninsResponse extends Entity
{
    /** @var ?string код ошибки */
    public $error;

    /** @var ?string текст ошибки */
    public $errorDescription;

    /** @var ?Errors */
    public $errors;

    /** @var ?Fault еще один вид ошибок в наркоманском API */
    public $fault;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'fault' => Fault::class,
            'errors' => Errors::class
        ]);
    }
}
