<?php

header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options; nosniff');

require 'conn.php';

function query($query, array $col=[]){
global $conn;
$stmt = $conn->prepare($query);    $stmt->bind_param(...$col);
    // $stmt->bind_param(format, variable, variable2);
}
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}   

?>