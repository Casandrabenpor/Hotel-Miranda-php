<?php
// Crear una instancia de la clase DatabaseConnector
require_once './database.php';
$errors = array();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario y validarlos
    $name = trim($_POST["name"]);
    if (empty($name)) {
        $errors[] = "El nombre es obligatorio.";
    }

    $phone = trim($_POST["phone"]);
    // Aquí podrías aplicar más validaciones según tus requisitos (por ejemplo, longitud, formato, etc.)

    $subject = trim($_POST["subject"]);
    if (empty($subject)) {
        $errors[] = "El asunto es obligatorio.";
    }

    $email = trim($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El email no es válido.";
    }

    $message = trim($_POST["message"]);
    if (empty($message)) {
        $errors[] = "El mensaje es obligatorio.";
    }

    // Si hay errores, mostrarlos al usuario
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } else {
        $db = new DatabaseConnector();
        $db->openConnection();
        $mysqli = $db->getMysqli();
        // Escapar los datos para prevenir inyecciones SQL (opcional, pero recomendado)
        $name = $mysqli->real_escape_string($name);
        $phone = $mysqli->real_escape_string($phone);
        $subject = $mysqli->real_escape_string($subject);
        $email = $mysqli->real_escape_string($email);
        $message = $mysqli->real_escape_string($message);

        // Construir la consulta SQL con sentencia preparada
        $query = "INSERT INTO post_form (name, phone, subject, email, message) 
                VALUES ('$name', '$phone', '$subject', '$email', '$message')";

        // Ejecutar la consulta
        $result = $db->query($query);

        // Verificar si la consulta fue exitosa
        if ($result) {
            echo "Datos guardados correctamente en la base de datos.";
        } else {
            echo "Error al guardar los datos.";
        }
    }
}
?>