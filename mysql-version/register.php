<?php
header('Content-Type: application/json');
// Настройки подключения к базе MySQL — замените на свои данные для доступа к ней
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marathon_db";
$conn = new mysqli($servername, $username, $password, $dbname); //Создание подключения
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => "Ошибка подключения к базе: " . $conn->connect_error]);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // Разрешаем только POST-запросы, другие методы запрещены
    http_response_code(405);
    echo json_encode(['error' => 'Метод не разрешён']);
    exit;
}
// Получение данных JSON из запроса
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Неверный JSON']);
    exit;
}

function validateData($data)  // Валидация данных по условию
{
    return (
        isset($data['name']) && is_string($data['name']) && trim($data['name']) !== '' &&
        isset($data['gender']) && in_array($data['gender'], ['Мужской', 'Женский']) &&
        isset($data['age']) && is_int($data['age']) && $data['age'] > 0 &&
        isset($data['experience']) && is_int($data['experience']) && $data['experience'] >= 0 &&
        isset($data['city']) && is_string($data['city']) && preg_match('/^[А-Яа-яЁё\s-]+$/u', $data['city'])
    );
}
if (!validateData($data)) {
    http_response_code(422);
    echo json_encode(['error' => 'Некорректные данные']);
    exit;
}
// Подготовка запроса с защитой от SQL-инъекций и добавление записи
$stmt = $conn->prepare("INSERT INTO participants (name, gender, age, experience, city) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param( // Привязываем параметры из запроса к подготовленному выражению
    "ssdds",
    $data['name'],
    $data['gender'],
    $data['age'],
    $data['experience'],
    $data['city']
);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка при записи в базу данных']);
}
$stmt->close();
$conn->close();
