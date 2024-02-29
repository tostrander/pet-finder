<?php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require("/home/tostrand/config.php");

//var_dump($_POST);

$petId = $_POST['petId'];
echo "<p>You entered $petId</p>";

// Connect to database
try {
    $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    //echo "Connected!";
}
catch (PDOException $e) {
    echo $e->getMessage();
    return;
}

// 1. Define the query
$sql = "SELECT * FROM pets WHERE id = :petid";

// 2. Prepare the statement
$statement = $dbh->prepare($sql);

// 3. Bind the parameters
$statement->bindParam(":petid", $petId);

// 4. Execute the statement
$statement->execute();

// 5. Process the results
$result = $statement->fetch(PDO::FETCH_ASSOC);
//var_dump($result);

if ($statement->rowCount() == 0) {
    echo "<p>No match found</p>";
}
else {
    $name = $result['name'];
    $type = $result['type'];
    $color = $result['color'];

    echo "<p>Pet ID: $petId</p>";
    echo "<p>Name: $name</p>";
    echo "<p>Type: $type</p>";
    echo "<p>Color: $color</p>";
}
