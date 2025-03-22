<script>
const chatBox = document.getElementById('chatBox');
chatBox.scrollTop = chatBox.scrollHeight;

<?php if(isset($_GET['id'])): ?>
const conn = new WebSocket('ws://localhost:8080');

// Po nawiązaniu połączenia, wyślij user_id do serwera
conn.onopen = function() {
    console.log('Connected to WebSocket server');
    conn.send(JSON.stringify({
        user_id: <?php echo $user->getUserId(); ?>
    }));
};

conn.onmessage = function(e) {
    const data = JSON.parse(e.data);
    const chatBox = document.getElementById('chatBox');
    pop();
    const messageClass = data.sender_id == <?php echo $user->getUserId(); ?> ? 'outcoming' : 'incoming';
    chatBox.innerHTML += `<div class="${messageClass}"><div class="message-data">${data.message}</div></div>`;
    chatBox.scrollTop = chatBox.scrollHeight;

    setTimeout(() => {
        $("#friendsList").load("friends.php");
    }, 100);
};

// Funkcja do wysyłania wiadomości
function sendMessage() {
    const message = document.querySelector('.input-message').value;
    if (message.trim() !== "") {
        const data = {
            message: message,
            sender_id: <?php echo $user->getUserId(); ?>, // Zalogowany użytkownik
            receiver_id: <?php echo $_GET['id']; ?> // Odbiorca z URL
        };

        // Wysłanie danych do serwera WebSocket
        conn.send(JSON.stringify(data));

        // Dodanie wiadomości do chat box (lokalne wyświetlanie)
        const chatBox = document.getElementById('chatBox');
        chatBox.innerHTML += `<div class="outcoming"><div class="message-data">${message}</div></div>`;
        chatBox.scrollTop = chatBox.scrollHeight;

        // Czyszczenie inputa
        document.querySelector('.input-message').value = '';

        setTimeout(() => {
            $("#friendsList").load("friends.php");
        }, 100);
    }
}
<?php endif; ?>

function clickPress(event) {
    if (event.key == "Enter" && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
}

function changeUsername(element) {
    let input = document.createElement("input");
    input.type = "text";
    input.className = element.className;
    input.value = element.innerText;
    element.replaceWith(input);
    input.focus();
}

function back() {
    window.location.href = "index.php";
}
</script>