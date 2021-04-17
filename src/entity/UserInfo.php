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
 * Информация о пользователе
 *
 * @link https://api.renins.com/devportal/apis/7dcb4d1c-e7a5-45ee-9617-c97e4252d0de/test
 */
class UserInfo extends Entity
{
    /** @var string Фамилия */
    public $lastName;

    /** @var string Имя */
    public $name;

    /** @var ?string Логин */
    public $userName;

    /** @var ?string Табельный номер */
    public $personnelNumber;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [['lastName', 'name', 'userName', 'personnelNumber'], 'trim'],
            [['lastName', 'name'], 'required']
        ];
    }
}
