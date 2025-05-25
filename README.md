# Api Template Replacer

Простой класс для заполнения строковых шаблонов template данными из объекта object

## Использование

```php  
$api = new Api();  
$path = $api->get_api_path(['id'=>1,'name'=>'Test'], '/api/%id%/%name%');  
echo $path; // /api/1/Test  
```  

## Запуск теста
```php  
php test.php   
```
Выводит результат и статус теста.