window.onload = () => {
    const lookupBtn = document.querySelector("#lookup"); // Button with id "lookup"
    const resultDiv = document.querySelector("#result"); // Div to display results
    const countryInput = document.querySelector("#country"); // Input field for country name

    // Add click event listener to the Lookup button
    lookupBtn.addEventListener("click", () => {
        const query = countryInput.value.trim(); // Get user input

        // Fetch data from world.php via AJAX
        fetch(`world.php?country=${query}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text(); // Parse response as text
            })
            .then(data => {
                resultDiv.innerHTML = data || "<p>No results found.</p>"; // Display data
            })
            .catch(error => {
                console.error("Fetch error:", error);
                resultDiv.innerHTML = `<p>Error fetching data: ${error.message}</p>`;
            });
    });
};
