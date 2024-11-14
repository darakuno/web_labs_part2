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
    var prev_send_message;

    function showMessage(messageHTML, messageType) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message ' + messageType;
        messageDiv.innerHTML = messageHTML;
        messagesDiv.appendChild(messageDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight; 
    }

    const websocket = new WebSocket("ws://localhost:8090");

    websocket.onopen = function(event) { 
        showMessage("Соединение установлено!", 'support');      
    };

    websocket.onmessage = function(event) {
        const Data = JSON.parse(event.data);
        // Проверяем, если сообщение не от пользователя
        const tempElement = document.createElement('div');
        tempElement.innerHTML = Data.message; 
        const messageText = tempElement.textContent || tempElement.innerText;
        const message = messageText.substring(messageText.indexOf(':') + 1).trim();

        if (message != prev_send_message) {
            showMessage(Data.message, 'support');
        }
        // console.log("mes", message);
        // console.log("prev mes", prev_send_message);
    };

    websocket.onerror = function(event) {
        showMessage("Проблема из-за ошибки", 'support');
    };

    websocket.onclose = function(event) {
        showMessage("Соединение закрыто", 'support');
    };

    sendButton.addEventListener("click", function() {
        const message = messageInput.value;
        if (message.trim() !== '') {
            const user_name = <?php echo json_encode(isset($_SESSION['user_login']) ? $_SESSION['user_login'] : "Пользователь"); ?>;
            const messageJSON = {
                chat_user: user_name,
                chat_message: message
            };
            prev_send_message = message;
            console.log(prev_send_message);
            websocket.send(JSON.stringify(messageJSON));
            showMessage(message, 'user'); 
            messageInput.value = ''; // Очистить поле после отправки
        }
    });

    messageInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            sendButton.click(); // Отправить сообщение при нажатии Enter
        }
    });
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
        background-color: #deecff;
        text-align: left; 
    }
</style>