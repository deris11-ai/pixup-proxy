<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['amount']) || !isset($input['name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Parâmetros inválidos']);
    exit;
}

$amount = $input['amount'];
$name = $input['name'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.pixup.com.br/pix/create");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "value" => $amount,
    "name" => $name
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer e69333ced34f06608d12546b00798797ea267af230d084bcac2edf78416a58a4",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(["error" => $error]);
} else {
    echo $response;
}
