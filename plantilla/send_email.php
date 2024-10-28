<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Comprobar si los campos están vacíos
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios.']);
        exit();
    }

    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'carlosegoavil2004@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'fwtvlxxlklswtyhj'; // Tu contraseña de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom('carlosegoavil2004@gmail.com', 'Carlos Daniel'); // Cambia esto
        $mail->addAddress('carlosegoavil2004@gmail.com'); // Correo del destinatario

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "Nombre: $name<br>Correo: $email<br>Asunto: $subject<br>Mensaje: $message";
        $mail->AltBody = "Nombre: $name\nCorreo: $email\nAsunto: $subject\nMensaje: $message";

        // Envío
        $mail->send();
        // Devolver respuesta JSON
        echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado correctamente.']);
    } catch (Exception $e) {
        // Devolver error en formato JSON
        echo json_encode(['status' => 'error', 'message' => "Error al enviar el mensaje. Mailer Error: {$mail->ErrorInfo}"]);
    }
}
?>
