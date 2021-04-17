# API страхования renins для Yii2

API: http://confluence.teamss.ru/pages/viewpage.action?pageId=18809309

Предупреждаю сразу, что из многих API, которые я повидал, данный документировано очень слабо, много абсурда и глупостей.

## Конфигурация

```php
$config = [
    'components' => [
        'renins' => [
            'class' => dicr\renins\Renins::class,
            'consumerKey' => 'ключ приложения',
            'consumerSecret' => 'секретный ключ'
        ] 
    ]
];
```

## Использование

Получение списка валют из словаря:

```php
/** @var dicr\renins\Renins $api */
$api = Yii::$app->get('renins');

/** @var dicr\renins\request\DictionaryRequest $request */
$request = $api->request([
    'class' => dicr\renins\request\DictionaryRequest::class,
    'product' => dicr\renins\request\DictionaryRequest::PRODUCT_KOR,
    'dictionaryCode' => dicr\renins\request\DictionaryRequest::DICTIONARY_CODE_CUR
]);

/** @var dicr\renins\request\DictionaryResponse $response */
$response = $request->send();
```
