<?php
/*
	task
	1. Напишите функцию подготовки строки, которая заполняет шаблон данными из указанного объекта
	2. Пришлите код целиком, чтобы можно его было проверить
	3. Придерживайтесь code style текущего задания
	4. По необходимости - можете дописать код, методы
	5. Разместите код в гите и пришлите ссылку
*/

/**
 * Класс для работы с API
 *
 * @author		Alexander
 * @version		v.1.0 (25/05/2025)
 */
class Api
{
    /**
     * Генерация массива подстановок вида "%key%" => value, для удобной замены в шаблонах
     *
     * @author		Alexander
     * @version		v.1.0 (25/05/2025)
     * @param       array $data
     * @return      array
     */
    private function make_placeholders(array $data): array
    {
        static $cache = [];

        $cache_key = md5(serialize($data));

        if (isset($cache[$cache_key])) {
            return $cache[$cache_key];
        }

        $replacements = [];
        foreach ($data as $key => $value) {
            $replacements["%$key%"] = rawurlencode($this->normalize_value($value));
        }

        return $cache[$cache_key] = $replacements;
    }

    /**
     * Нормализует значение для подстановки в шаблон.
     *
     * @author		Alexander
     * @version		v.1.0 (25/05/2025)
     * @param       mixed $value
     * @return      string
     */
    private function normalize_value(mixed $value): string
    {
        //В рамках задачи — простая реализация, но можно расширить
        //под DateTime, массивы и прочие нестандартные поля
        return (string) $value;
    }

    /**
     * Заполняет строковый шаблон template данными из объекта object
     *
     * @author		Alexander
     * @version		v.1.0 (25/05/2025)
     * @param		array $data
     * @param		string $template
     * @return		string
     */
    public function get_api_path(array $data, string $template): string
    {
        return strtr($template, $this->make_placeholders($data));
    }
}

$user =
    [
        'id'		=> 20,
        'name'		=> 'John Dow',
        'role'		=> 'QA',
        'salary'	=> 100
    ];

$api_path_templates =
    [
        "/api/items/%id%/%name%",
        "/api/items/%id%/%role%",
        "/api/items/%id%/%salary%"
    ];

$api = new Api();

$api_paths = array_map(function ($api_path_template) use ($api, $user)
{
    return $api->get_api_path($user, $api_path_template);
}, $api_path_templates);

echo json_encode($api_paths, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);

$expected_result = ['/api/items/20/John%20Dow', '/api/items/20/QA', '/api/items/20/100'];

$test_result_message = $api_paths === $expected_result ? "\033[32m✅ Тест завершен успешно!" : "\033[31m❌ Ошибка, данные не совпадают!";

echo PHP_EOL . $test_result_message."\033[0m".PHP_EOL;