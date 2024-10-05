<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $order = htmlspecialchars($_POST['order']);
    
    // Обработка файла
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file'];
        $filePath = 'uploads/' . basename($file['name']);
        
        // Проверка типа файла и загрузка
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $fileUploaded = true;
            } else {
                $fileUploaded = false;
            }
        } else {
            $fileUploaded = false;
        }
    }

    $to = "tortlarbakuvip@gmail.com";  // Замените на ваш email
    $subject = "Yeni Sifariş " . $name;
    $message = "Ad, Soyad: " . $name . "\nEmail: " . $email . "\nЗаказ: \n" . $order;

    // Добавление файла к сообщению
    if ($fileUploaded) {
        $message .= "\nŞəkil: " . $filePath;
    } else {
        $message .= "\nŞəkil Yoxdur.";
    }

    $headers = "From: " . $email;

    // Отправка письма
    if (mail($to, $subject, $message, $headers)) {
        echo "Sifarişiniz uğurla göndərildi!";
    } else {
        echo "Təəssüf ki, sifarişinizi göndərərkən xəta baş verdi. Yenidən cəhd edin.";
    }
} else {
    echo "Yanlış göndərmə üsulu.";
}

?>