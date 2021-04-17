<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.04.21 13:06:30
 */

declare(strict_types = 1);
namespace dicr\tests;

use dicr\renins\Renins;
use dicr\renins\request\DictionaryRequest;
use PHPUnit\Framework\TestCase;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;

/**
 * Class ReninsTest
 */
class ReninsTest extends TestCase
{
    /**
     * API
     *
     * @return Renins
     * @throws InvalidConfigException
     */
    private static function api(): Renins
    {
        return Yii::$app->get('src');
    }

    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function testDictionary(): void
    {
        /** @var DictionaryRequest $req */
        $req = self::api()->request([
            'class' => DictionaryRequest::class,
            'product' => DictionaryRequest::PRODUCT_KOR,
            'dictionaryCode' => DictionaryRequest::DICTIONARY_CODE_CUR
        ]);

        $res = $req->send();
        self::assertNotEmpty($res->dictionaries[0]->values);
    }
}
