<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:05:53
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\renins\ReninsResponse;

/**
 * Class PrintPolicyResponse
 */
class PrintPolicyResponse extends ReninsResponse
{
    /** @var string Номер оформленного и распечатанного полиса */
    public $number;

    /** @var string Адрес документа для печати */
    public $url;
}
