<?php

    $connection = new mysqli("localhost", "root", "", "basecita");

    if ($connection->connect_errno) {
        echo "Falló la conexión " . $connection->connect_errno;
    }

    $connection->set_charset("utf8");

    $query = "SELECT * FROM personas";

    $result = $connection->query($query);

    if ($connection->errno) {
        die ($$connection->error);
    }

    while ($row=$result->fetch_assoc()) {
        foreach ($row as $key => $value) {
            echo $value . " ";
        }
        echo "<br>";
    }

    $connection->close();

?>