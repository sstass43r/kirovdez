<?php

$method = $_SERVER['REQUEST_METHOD'];

//Recaptcha verification
if ($method === 'POST') {
	$secret_key = "6LfvlwYpAAAAAMQg0cXTaEjKdEgIYuLBeD1FZCx7";
	$response = $_POST['g-recaptcha-response'];
	$remoteip = $_SERVER['REMOTE_ADDR'];
	$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response&remoteip=$remoteip";

	$recaptcha = json_decode(file_get_contents($url));
	if (!$recaptcha->success) {
		http_response_code(400);
		echo "Recaptcha verification failed.";
		exit();
	}
}

//Script Foreach
$c = true;
if ($method === 'POST') {
	$project_name = trim($_POST["project_name"]);
	$admin_email  = trim($_POST["admin_email"]);
	$form_subject = trim($_POST["form_subject"]);

	$message .= "<table style='border-collapse: collapse; width: 100%;'>";
	foreach ($_POST as $key => $value) {
		if ($value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" && $key != "g-recaptcha-response") {
			$message .= "
			<tr>
				<td style='border: 1px solid #ededed; padding: 8px;'>$key</td>
				<td style='border: 1px solid #ededed; padding: 8px;'>$value</td>
			</tr>
			";
		}
	}

} else if ($method === 'GET') {
	$project_name = trim($_GET["project_name"]);
	$admin_email  = trim($_GET["admin_email"]);
	$form_subject = trim($_GET["form_subject"]);

	foreach ($_GET as $key => $value) {
		if ($value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject") {
			$message .= "
			" . (($c = !$c) ? '<div>':'<div style=\"display: flex;\">') . "
			<div style='padding-left: 10px;'><b>$key</b></div>
			<div style='padding-left: 10px;'>$value</div>
		</div>
		";
		}
	}
}

$message = str_replace('_', ' ', $message);

function adopt($text) {
	return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'from: Гармония-Уюта43.рф <send@гармония-уюта43.рф>' . PHP_EOL .
'Reply-To: '.$admin_email.'' . PHP_EOL;

mail($admin_email, adopt($form_subject), $message, $headers );
