<?php
require_once './validation.php';

require_once './database.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario y validarlos
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $subject = trim($_POST["subject"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Validar los campos del formulario
    $errors = validationForm($name, $phone, $subject, $email, $message);
    // Si hay errores, mostrarlos al usuario
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } else {
        $db = new DatabaseConnector();
        $db->openConnection();
        $mysqli = $db->getMysqli();
        // Escapar los datos para prevenir inyecciones SQL 
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