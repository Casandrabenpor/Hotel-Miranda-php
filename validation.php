<?php
function validationForm($name, $phone, $subject, $email, $message)
{
    $errors = array();
    function validationPhone($telefono)
    {
        // Eliminar cualquier carácter que no sea dígito del número de teléfono
        $telefono = preg_replace('/[^0-9]/', '', $telefono);

        // Verificar si el número de teléfono tiene el formato adecuado (10 dígitos en este caso)
        $patron = '/^\d{9}$/';

        return preg_match($patron, $telefono);
    }
    if (empty($name)) {
        $errors[] = "El nombre es obligatorio.";
    }
    if (empty($phone)) {
        $errors[] = "El número de teléfono es obligatorio.";
    } elseif (!validationPhone($phone)) {
        $errors[] = "El número de teléfono no es válido. Debe tener 9 dígitos.";
    }
    if (empty($subject)) {
        $errors[] = "El asunto es obligatorio.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El email no es válido.";
    }
    if (empty($message)) {
        $errors[] = "El mensaje es obligatorio.";
    }
    return $errors;
}
?>