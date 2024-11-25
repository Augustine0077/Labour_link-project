// Function to ban a user permanently
function banUser(email, role) {
    // Sending a POST request to the PHP backend
    fetch('permanent_ban_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        // Sending email and role as JSON data
        body: JSON.stringify({ email: email, role: role })
    })
    .then(response => response.json()) // Parsing the JSON response
    .then(data => {
        // Check for error in the response
        if (data.error) {
            alert('Error: ' + data.error); // Display detailed backend error
        } else {
            alert(data.success); // Display success message
        }
    })
    .catch(error => {
        alert('Error: ' + error.message); // Handle any network or other errors
    });
}

// Example call to ban a user (Replace with your actual integration in your UI)
banUser('user@example.com', 'seeker'); // Replace with the actual email and role
