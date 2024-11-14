<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        #chat-box {
            border: 1px solid #ccc;
            height: 300px;
            overflow-y: scroll;
            padding: 10px;
            background-color: #fff;
            margin-bottom: 10px;
        }
        .chat-connection-ack {
            color: green;
        }
        .error {
            color: red;
        }
        .user-message {
            color: blue;
        }
        .system-message {
            color: gray;
        }
        #frmChat {
            display: flex;
        }
        #chat-message {
            flex-grow: 1;
            padding: 10px;
            margin-right: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h1>Чат</h1>
    <div id="chat-box"></div>
    
    <form id="frmChat">
        <input type="text" id="chat-user" placeholder="Ваше имя" required>
        <input type="text" id="chat-message" placeholder="Введите сообщение" required>
        <button type="submit">Отправить</button>
    </form>

    <script>
        function showMessage(messageHTML) {
            $('#chat-box').append(messageHTML);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight); // Прокрутка вниз
        }

        $(document).ready(function(){
            var websocket = new WebSocket("ws://localhost:8090"); 
            websocket.onopen = function(event) { 
                showMessage("<div class='chat-connection-ack'>Соединение установлено!</div>");      
            }
            websocket.onmessage = function(event) {
                var Data = JSON.parse(event.data);
                showMessage("<div class='"+Data.message_type+"'>"+Data.message+"</div>");
                $('#chat-message').val('');
            };
            
            websocket.onerror = function(event){
                showMessage("<div class='error'>Проблема из-за ошибки</div>");
            };
            websocket.onclose = function(event){
                showMessage("<div class='chat-connection-ack'>Соединение закрыто</div>");
            }; 
            
            $('#frmChat').on("submit",function(event){
                event.preventDefault();
                $('#chat-user').attr("type","hidden");        
                var messageJSON = {
                    chat_user: $('#chat-user').val(),
                    chat_message: $('#chat-message').val()
                };
                websocket.send(JSON.stringify(messageJSON));
            });
        });
    </script>

</body>
</html>
