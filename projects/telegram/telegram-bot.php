<?php

$token = "449164880:AAFUdtUiVzI7rP6W49pjyVvMjmFPM5Ef2pg";

$response = file_get_contents("https://api.telegram.org/bot{$token}/getMe");

$response = json_decode($response);

echo "{$response->result->username} was here!";
echo "<pre>";
print_r($response);
echo "</pre>";

