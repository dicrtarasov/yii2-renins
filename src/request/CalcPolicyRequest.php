<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 25.04.21 03:08:36
 */

declare(strict_types = 1);
namespace dicr\renins\request;

use dicr\json\EntityValidator;
use dicr\renins\entity\Error;
use dicr\renins\entity\Policy;
use dicr\renins\ReninsRequest;
use dicr\renins\ReninsResponse;
use yii\base\Exception;
use yii\httpclient\Response;

use function array_map;
use function array_merge;

/**
 * Class IpotekaCalculate
 *
 * @link http://confluence.teamss.ru/pages/viewpage.action?pageId=18809811
 */
class CalcPolicyRequest extends ReninsRequest
{
    /** @var string */
    public $productType;

    /** @var Policy */
    public $policyCalc;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'policyCalc' => Policy::class
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['productType', 'trim'],
            ['productType', 'required'],

            ['policyCalc', 'required'],
            ['policyCalc', EntityValidator::class]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function url(): string
    {
        return '/IpotekaAPI/1.0.0/calculate';
    }

    /**
     * @inheritDoc
     */
    protected function response(Response $response): ReninsResponse
    {
        return new CalcPolicyResponse([
            'json' => $response->data
        ]);
    }

    /**
     * @inheritDoc
     */
    public function send(): CalcPolicyResponse
    {
        /** @var CalcPolicyResponse $res */
        $res = parent::send();

        // дополнительные ошибки в результатах
        foreach ($res->calcPolicyResult->calcResults ?? [] as $calcResult) {
            if (! empty($calcResult->errors->errors)) {
                throw new Exception(implode('; ', array_map(
                    static fn(Error $error) => $error->detailMessage ?: $error->message,
                    $calcResult->errors->errors
                )));
            }
        }

        return $res;
    }
}
