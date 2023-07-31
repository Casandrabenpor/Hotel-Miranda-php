<?php
if (isset($_POST['submit'])) {
    // Obtener los datos del formulario
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    echo "Nombre: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Teléfono: " . $phone . "<br>";
    echo "Asunto: " . $subject . "<br>";
    echo "Message: " . $message . "<br>";

    // Crear una instancia de la clase DatabaseConnector
    require_once './database.php';
    $db = new DatabaseConnector();

    // Escapar los datos para prevenir inyecciones SQL (opcional, pero recomendado)
    $name = $db->mysqli->real_escape_string($name);
    $phone = $db->mysqli->real_escape_string($phone);
    $subject = $db->mysqli->real_escape_string($subject);
    $email = $db->mysqli->real_escape_string($email);
    $message = $db->mysqli->real_escape_string($message);

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
?>