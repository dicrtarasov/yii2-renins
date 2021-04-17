<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:05:53
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\renins\entity\Errors;
use dicr\renins\ReninsResponse;

use function array_merge;

/**
 * Class GetIssueProcessStatusResponse
 */
class GetIssueProcessStatusResponse extends ReninsResponse
{
    /** @var string ($uuid) */
    public $accID;

    /** @var string ID полиса, по которому требуется провести проверку статуса онлайн-оплаты */
    public $policyID;

    /**
     * @var string состояние онлайн-оплаты договора
     * ISSUE_PREPARATION, PAYMENT_PREPARATION, PAYMENT_WAITING, ISSUE_FINALIZATION, ISSUE_SUCCESSFUL, ISSUE_ERROR
     */
    public $state;

    /** @var bool */
    public $isError;

    /** @var ?Errors */
    public $processErrors;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'processErrors' => Errors::class
        ]);
    }
}
