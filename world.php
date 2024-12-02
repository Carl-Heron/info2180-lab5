<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    $country = isset($_GET['country']) ? htmlspecialchars($_GET['country']) : '';
    $lookup = isset($_GET['lookup']) ? htmlspecialchars($_GET['lookup']) : '';

    if ($lookup === "cities") {
        // Fetch cities for the given country
        $stmt = $conn->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population 
            FROM cities 
            JOIN countries ON cities.country_code = countries.code 
            WHERE countries.name LIKE :country
        ");
        $stmt->bindValue(':country', "%$country%");
    } else {
        // Fetch countries (default behavior)
        $stmt = $conn->prepare("
            SELECT name, continent, independence_year, head_of_state 
            FROM countries 
            WHERE name LIKE :country
        ");
        $stmt->bindValue(':country', "%$country%");
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        echo "<table border='1' cellspacing='0' cellpadding='5'>";
        if ($lookup === "cities") {
            // Table for city data
            echo "<thead><tr><th>City Name</th><th>District</th><th>Population</th></tr></thead>";
            echo "<tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                echo "<td>" . htmlspecialchars($row['population']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
        } else {
            // Table for country data
            echo "<thead><tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr></thead>";
            echo "<tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
                echo "<td>" . (!empty($row['independence_year']) ? htmlspecialchars($row['independence_year']) : "N/A") . "</td>";
                echo "<td>" . (!empty($row['head_of_state']) ? htmlspecialchars($row['head_of_state']) : "N/A") . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
        }
        echo "</table>";
    } else {
        echo "<p>No results found.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
