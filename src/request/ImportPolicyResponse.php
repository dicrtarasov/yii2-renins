<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:05:53
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\renins\entity\Policy;
use dicr\renins\ReninsResponse;

use function array_merge;

/**
 * Class ImportPolicyResponse
 */
class ImportPolicyResponse extends ReninsResponse
{
    /** @var Policy */
    public $policy;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'policy' => Policy::class
        ]);
    }
}
