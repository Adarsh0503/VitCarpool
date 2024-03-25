
document.addEventListener("DOMContentLoaded", function() {
    const searchFormButton = document.getElementById("searchFormButton");
    const searchForm = document.getElementById("searchForm");
    const searchResults = document.getElementById("searchResults");

    searchFormButton.addEventListener("click", function() {
        searchForm.style.display = "block";
    });

    searchForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        const formData = new FormData(searchForm);
        const origin = formData.get("origin");
        const destination = formData.get("destination");
        const date = formData.get("date");

        // Fetch search results using search_users.php
        fetch(`search_users.php?origin=${origin}&destination=${destination}&date=${date}`)
            .then(response => response.text())
            .then(data => {
                searchResults.innerHTML = data; // Display search results
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });
});

