window.onload = () => {
    const lookupBtn = document.querySelector("#lookup");
    const lookupCitiesBtn = document.querySelector("#lookup-cities");
    const resultDiv = document.querySelector("#result");

    function fetchData(query, lookupType) {
        resultDiv.innerHTML = "<p>Loading...</p>"; // Show loading message
        fetch(`world.php?country=${query}&lookup=${lookupType}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then(data => {
                resultDiv.innerHTML = data; // Render the returned HTML
            })
            .catch(error => {
                console.error("Fetch error:", error);
                resultDiv.innerHTML = "<p>Error fetching data.</p>";
            });
    }

    // Event listener for country lookup
    lookupBtn.addEventListener("click", () => {
        const query = document.querySelector("#country").value.trim();
        if (query === "") {
            resultDiv.innerHTML = "<p>Please enter a country name.</p>";
            return;
        }
        fetchData(query, "country");
    });

    // Event listener for city lookup
    lookupCitiesBtn.addEventListener("click", () => {
        const query = document.querySelector("#country").value.trim();
        if (query === "") {
            resultDiv.innerHTML = "<p>Please enter a country name.</p>";
            return;
        }
        fetchData(query, "cities");
    });
};
