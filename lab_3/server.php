<?php
$host = 'localhost';
$port = 8080;

echo "Сервер работает!";

// Создаем сокет
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, $host, $port);
socket_listen($socket);

$clients = [];

while (true) {
    // Копируем массив клиентов для обработки
    $read = $clients;
    $read[] = $socket;

    // Ожидаем подключения
    socket_select($read, $null, $null, 0);

    // Проверяем новые подключения
    if (in_array($socket, $read)) {
        $newClient = socket_accept($socket);
        $clients[] = $newClient;

        // Обрабатываем handshake
        $headers = socket_read($newClient, 1024);
        $key = '';
        preg_match('/Sec-WebSocket-Key: (.*)rn/', $headers, $matches);
        if (isset($matches[1])) {
            $key = $matches[1];
        }
        $acceptKey = base64_encode(pack('H*', sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $headersResponse = "HTTP/1.1 101 Switching Protocolsrn" .
                          "Upgrade: websocketrn" .
                          "Connection: Upgradern" .
                          "Sec-WebSocket-Accept: " . $acceptKey . "rnrn";
        socket_write($newClient, $headersResponse, strlen($headersResponse));
        $read = array_diff($read, [$socket]);
    }

    foreach ($read as $client) {
        $data = socket_read($client, 1024);
        if ($data === false) {
            // Удаляем отключившегося клиента
            unset($clients[array_search($client, $clients)]);
            continue;
        }

        // Декодируем сообщение
        $decodedData = unmask($data);
        
        // Отправляем сообщение всем клиентам
        foreach ($clients as $sendClient) {
            if ($sendClient != $client) {
                socket_write($sendClient, mask($decodedData), strlen(mask($decodedData)));
            }
        }
    }
}

// Функция для маскировки данных
function mask($text) {
    $b1 = 0;
    $length = strlen($text);
    if ($length <= 125) {
        $b1 = 128; // 1000 0000
        $b2 = $length;
    } elseif ($length >= 126 && $length <= 65535) {
        $b1 = 126; // 0111 1110
        $b2 = pack('n', $length);
    } else {
        $b1 = 127; // 0111 1111
        $b2 = pack('P', $length);
    }
    return chr($b1) . $b2 . $text;
}

// Функция для декодирования данных
function unmask($text) {
    $length = ord($text[1]) & 127;
    if ($length === 126) {
        $length = unpack('n', substr($text, 2, 2))[1];
        $mask = substr($text, 4, 4);
        return substr($text, 8) ^ str_repeat($mask, ceil((strlen($text) - 8) / 4));
    } elseif ($length === 127) {
        return ''; // Поддержка больших сообщений не реализована
    } else {
        $mask = substr($text, 2, 4);
        return substr($text, 6) ^ str_repeat($mask, ceil((strlen($text) - 6) / 4));
    }
}


