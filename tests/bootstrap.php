<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 17.06.21 05:30:20
 */

/** @noinspection PhpMissingDocCommentInspection */
declare(strict_types = 1);

/**  */
const YII_ENV = 'dev';

/**  */
const YII_DEBUG = true;

require_once(__DIR__ . '/local.php');
require_once(dirname(__DIR__) . '/vendor/autoload.php');
require_once(dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php');

/** @noinspection PhpUnhandledExceptionInspection */
new yii\console\Application([
    'id' => 'test',
    'basePath' => dirname(__DIR__),
    'components' => [
        'cache' => yii\caching\FileCache::class,

        'log' => [
            'class' => yii\log\Dispatcher::class,
            'targets' => [
                'file' => [
                    'class' => yii\log\FileTarget::class,
                    'except' => ['yii\httpclient\CurlTransport::send'],
                    'levels' => ['error', 'warning', 'info', 'trace']
                ]
            ]
        ],

        'src' => [
            'class' => dicr\renins\Renins::class,
            'consumerKey' => CONSUMER_KEY,
            'consumerSecret' => CONSUMER_SECRET
        ]
    ],
    'bootstrap' => ['log']
]);
