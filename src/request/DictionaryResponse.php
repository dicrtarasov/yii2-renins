<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:05:53
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\renins\entity\Dictionary;
use dicr\renins\ReninsResponse;

use function array_merge;

/**
 * Class DictionaryResponse
 */
class DictionaryResponse extends ReninsResponse
{
    /** @var array типы */
    public $types;

    /** @var Dictionary[] */
    public $dictionaries;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'dictionaries' => [Dictionary::class]
        ]);
    }
}
