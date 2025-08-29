<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // Разрешаем только POST-запросы, другие методы запрещены
    http_response_code(405);
    echo json_encode(['error' => 'Метод не разрешён']);
    exit;
}
$data = json_decode(file_get_contents('php://input'), true); // Получаем JSON из тела запроса и декодируем в массив
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Неверный JSON']);
    exit;
}
function validateData($data)
{ // Функция валидации данных из запроса с проверкой всех полей
    if (
        !isset($data['name']) || !is_string($data['name']) || trim($data['name']) === '' ||
        !isset($data['gender']) || !in_array($data['gender'], ['Мужской', 'Женский']) ||
        !isset($data['age']) || !is_int($data['age']) || $data['age'] < 1 ||
        !isset($data['experience']) || !is_int($data['experience']) || $data['experience'] < 0 ||
        !isset($data['city']) || !is_string($data['city']) || !preg_match('/^[А-Яа-яЁё\s-]+$/u', $data['city'])
    ) {
        return false;
    }
    return true;
}
if (!validateData($data)) {
    http_response_code(422);
    echo json_encode(['error' => 'Некорректные данные']);
    exit;
}
$file = 'registrations.json'; // Путь к JSON-файлу для хранения регистраций
$registrations = [];
if (file_exists($file)) { // Если файл существует, читаем его и пытаемся декодировать JSON в массив
    $content = file_get_contents($file);
    $registrations = json_decode($content, true);
    if (!is_array($registrations)) {
        $registrations = [];
    }
}
$registrations[] = [ // Добавляем новую регистрацию в массив
    'name' => trim($data['name']),
    'gender' => $data['gender'],
    'age' => $data['age'],
    'experience' => $data['experience'],
    'city' => trim($data['city']),
];
if (file_put_contents($file, json_encode($registrations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка при сохранении файла']);
    exit;
}
echo json_encode(['success' => true]);
