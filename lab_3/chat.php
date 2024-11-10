<?php 
$current_page = $_GET['page'];
$current_page.='.php'; ?>

<div class='title'>Чат службы поддержки</div>
<div id="messages"></div>
<input type="text" id="message-input" placeholder="Введите ваше сообщение..." />
<button id="send-button">Отправить</button>

<script>
    const messagesDiv = document.getElementById('messages');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');

    // Создаем WebSocket соединение
    const socket = new WebSocket('ws://localhost:8080');

    // Обработка входящих сообщений
    socket.onmessage = function(event) {
        const messageElement = document.createElement('div');
        messageElement.textContent = event.data;

        // Добавляем класс для сообщения поддержки
        messageElement.classList.add('message', 'support');
        
        messagesDiv.appendChild(messageElement);
        messagesDiv.scrollTop = messagesDiv.scrollHeight; // Прокручиваем вниз
    };

    // Отправка сообщения
    sendButton.onclick = function() {
        const message = messageInput.value;
        if (message) {
            const messageElement = document.createElement('div');
            messageElement.textContent = message;

            // Добавляем класс для сообщения пользователя
            messageElement.classList.add('message', 'user');
            
            messagesDiv.appendChild(messageElement);
            socket.send(message); // Отправляем сообщение на сервер
            messageInput.value = ''; // Очищаем поле ввода
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // Прокручиваем вниз
        }
    };

    // Обработка ошибок
    socket.onerror = function(error) {
        console.error('Ошибка WebSocket:', error);
    };
</script>



<style>
    #messages {
        border: 1px solid #ccc;
        border-radius: 5px;
        height: 300px;
        overflow-y: scroll;
        margin-bottom: 10px;
        padding: 10px;
        background-color: #fff;
        margin-left: 20px;
        margin-right: 10px;
    }
    #message-input {
        width: 75%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        margin-left: 20px;
    }

    #send-button {
        width: 20%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #28a745;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #send-button:hover {
        background-color: #218838;
    }

    .message {
        margin-bottom: 10px;
        padding: 5px;
        border-radius: 5px;
    }

    .message.user {
        background-color: #d1e7dd;
        text-align: right;
    }

    .message.support {
        background-color: #f8d7da;
        text-align: left; 
    }
</style>