<?php
require '../cfg.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['themeName']) && isset($_POST['outcoming']) && isset($_POST['incoming'])) {
        $themeName = $_POST['themeName'];
        $outcoming = $_POST['outcoming'];
        $incoming = $_POST['incoming'];

        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['file'];

            // Sprawdzanie typu pliku
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($file['type'], $allowedTypes)) {
                $uploadDir = '../themes/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $filePath = $uploadDir . basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    $plik=basename($file['name']);
                    $colors="['$incoming','$outcoming']";
                    $chat->addTheme(
                        $plik,$themeName,$colors);
                    echo'success';
                } else {
                    echo "Wystąpił problem podczas przesyłania pliku.";
                }
            } else {
                echo "Dozwolone są tylko obrazy JPEG, PNG i GIF.";
            }
        } else {
            echo "Nie załadowano pliku.";
        }
    } else {
        echo "Brak wymaganych danych.";
    }
}
?>