<?php

$token = "449164880:AAFUdtUiVzI7rP6W49pjyVvMjmFPM5Ef2pg";

$response = file_get_contents("https://api.telegram.org/bot{$token}/getMe");

echo json_decode($response);

