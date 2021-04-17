<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:13:02
 */

declare(strict_types = 1);
namespace dicr\renins\entity;

use dicr\renins\Entity;

/**
 * Ошибка.
 */
class Error extends Entity
{
    /** @var string Сообщение ошибки */
    public $message;

    /**
     * @var string Тип ошибки
     * - Программа неприменима для данных параметров,
     * - Нарушение ограничений по параметрам,
     * - Некорректный ввод данных,
     * - Системная
     */
    public $type;

    /** @var string Детализированное сообщение об ошибке */
    public $detailMessage;
}
