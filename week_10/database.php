<?php

$conn = mysqli_connect("localhost", "root", "root", "mydb", "3307");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully<br>";
}

$sql = "
SELECT * FROM student;
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row["firstName"]}</td><td>{$row["lastname"]}</td><td>{$row["studentID"]}</td><td>{$row["school"]}</td><td>{$row["enrolled"]}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

mysqli_close($conn);
