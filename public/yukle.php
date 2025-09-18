<?php
require_once dirname(__DIR__, 1) . "/src/init.php";

use \Core\Auth;
use \Core\OutputManager;

$headers = getallheaders();

// Token kontrol
// Authorization: Token askdjalfklnlsdg9.qjflkelkfjlkw
$token = null;
$authHeader = $headers['authorization'] ?? $headers['Authorization'] ?? null;
if ($authHeader && preg_match('/Token\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
}

if($token === null){
    OutputManager::error("Yok abicim, token koymamışsın.", 401);
    die();
}

$tokenData = Auth::verifyToken($token);
if($tokenData === null){
    OutputManager::error("Token yanlış, yoksa sen başka birisi misin?", 401);
    die();
}

// tmm token kontrol ettik artık sıkıntı yok
// artık dosyayı kaydedelim
$fileKey = "yazi";

if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
    OutputManager::error("Oğlum bi hata olmuş, yoksa sen mi yaptın?", 400);
    die();
}

$file = $_FILES[$fileKey];

if ($file['size'] > 5 * 1024 * 1024) {
    OutputManager::error("Dosya kocaman. Maksimum 5MB");
    die();
}

// dosyayı kaydedek
$loop = 0;
do {
    $yaziId = random_int(100000, 999999);

    $yaziKlasor = BASE_PATH . "/yazilar/";
    $kayitAdresi = $yaziKlasor . $yaziId . ".y";

    $loop += 1;

    if($loop === 5){
        OutputManager::error("5 kere random id koyamadık, belki 899999 tane yazı vardır, sınıra gelmişsindir.", 500);
        die();
    }
} while (file_exists($kayitAdresi));

if (!is_dir($yaziKlasor)) {
    mkdir($yaziKlasor, 0755, true);
}

if (!move_uploaded_file($file['tmp_name'], $kayitAdresi)) {
    OutputManager::error("Dosyayı yerinden oynatamadık, oturan boğa gibi oturmuş.", 500);
    die();
}

OutputManager::info("Oldu bittiye gelmek.");
die();