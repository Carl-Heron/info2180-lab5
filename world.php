<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Check if the 'country' parameter is provided in the GET request
    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $country = htmlspecialchars($_GET['country']); // Sanitize input
        // Use a prepared statement with the LIKE operator to filter results
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->bindValue(':country', "%$country%"); // Bind the country parameter
    } else {
        // If no country parameter is provided, fetch all countries
        $stmt = $conn->query("SELECT * FROM countries");
    }

    // Execute the query and fetch results
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the HTML output
    if ($results) {
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li>" . htmlspecialchars($row['name']) . " is ruled by " . htmlspecialchars($row['head_of_state']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No results found.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
