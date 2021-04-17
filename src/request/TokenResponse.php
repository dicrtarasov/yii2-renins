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

use function time;

/**
 * Токен доступа.
 *
 * @property-read int $createTime
 * @property-read ?int $expireTime
 */
class TokenResponse extends ReninsResponse
{
    /** @var string токен доступа */
    public $accessToken;

    /** @var string токен обновления */
    public $refreshToken;

    /** @var string права доступа ("default") */
    public $scope;

    /** @var string ("Bearer") */
    public $tokenType;

    /** @var int время жизни (3600) */
    public $expiresIn;

    /** @var int время создания */
    private $_createTime;

    /**
     * TokenResponse constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->_createTime = time();

        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    public function attributeFields(): array
    {
        return [
            'accessToken' => 'access_token',
            'tokenType' => 'token_type',
            'expiresIn' => 'expires_in'
        ];
    }

    /**
     * Время создания.
     *
     * @return int
     */
    public function getCreateTime(): int
    {
        return $this->_createTime;
    }

    /**
     * Время окончания.
     *
     * @return ?int
     */
    public function getExpireTime(): ?int
    {
        return empty($this->expiresIn) ? null : $this->createTime + $this->expiresIn;
    }
}
