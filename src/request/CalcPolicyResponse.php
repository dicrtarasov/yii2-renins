<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 25.04.21 00:08:48
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\renins\entity\CalcPolicyResults;
use dicr\renins\ReninsResponse;

use function array_merge;

/**
 * Class CalcPolicyResponse
 */
class CalcPolicyResponse extends ReninsResponse
{
    /** @var ?string идентификатор рассчета */
    public $calcID;

    /** @var CalcPolicyResults */
    public $calcPolicyResult;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'calcPolicyResult' => CalcPolicyResults::class
        ]);
    }
}
