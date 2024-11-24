<section>
    <h2>The Sports and Wellness Development</h2>

    <form id="sportForm" onsubmit="submitSportForm(event)" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" placeholder="Enter your name" required><br>

        <label for="section">Section:</label><br>
        <input type="text" id="section" name="section" placeholder="Enter your section" required><br>

        <label for="sportslist">List of Sports in KLD:</label><br>
        <select id="sportslist" name="sportslist" required>
            <option value="">Select a sport</option>
            <option value="badminton">Badminton (Men & Women)</option>
            <option value="basketball-men">Basketball (Men)</option>
            <option value="basketball-women">Basketball (Women)</option>
            <option value="cheerdance">Cheerdance</option>
            <option value="sepak-takraw">Sepak Takraw</option>
            <option value="table-tennis">Table Tennis (Men & Women)</option>
            <option value="volleyball-men">Volleyball (Men)</option>
            <option value="volleyball-women">Volleyball (Women)</option>
            <option value="chess">Chess</option>
        </select><br>

        <!-- Your file input for PSA -->
        <div class="file-upload-container">
    <label for="psa">Upload PSA:</label>
    <input type="file" id="psa" name="psa" accept="image/*,application/pdf" required>
    <span id="psaFileName"></span>
</div>
        <!-- Your file input for Grade -->
        <div class="file-upload-container">
        <label for="grade">Upload Grade Photo Copy:</label><br>
        <input type="file" id="grade" name="grade" accept="image/*,application/pdf" required><br>
        <span id="gradeFileName"></span> <!-- Display file name here -->
        </div>
        <!-- Your file input for School ID -->
        <div class="file-upload-container">
        <label for="school-id">Upload School ID:</label><br>
        <input type="file" id="school-id" name="school-id" accept="image/*,application/pdf" required><br>
        <span id="schoolIdFileName"></span> <!-- Display file name here -->
        </div>
        <button type="submit">Submit</button>
    </form>
</section>

<script>
// Function to display the name of the selected file for PSA
document.getElementById('psa').addEventListener('change', function() {
    const fileName = this.files[0] ? this.files[0].name : '';
    const fileNameElement = document.getElementById('psaFileName');
    fileNameElement.textContent = fileName;
    fileNameElement.style.display = fileName ? 'inline' : 'none'; // Hide if no file
});

// Function to display the name of the selected file for Grade
document.getElementById('grade').addEventListener('change', function() {
    const fileName = this.files[0] ? this.files[0].name : '';
    const fileNameElement = document.getElementById('gradeFileName');
    fileNameElement.textContent = fileName;
    fileNameElement.style.display = fileName ? 'inline' : 'none'; // Hide if no file
});

// Function to display the name of the selected file for School ID
document.getElementById('school-id').addEventListener('change', function() {
    const fileName = this.files[0] ? this.files[0].name : '';
    const fileNameElement = document.getElementById('schoolIdFileName');
    fileNameElement.textContent = fileName;
    fileNameElement.style.display = fileName ? 'inline' : 'none'; // Hide if no file
});

// Form submission with SweetAlert
function submitSportForm(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    const form = document.getElementById("sportForm");
    const formData = new FormData(form); // Collect form data

    // Show SweetAlert loading animation
    Swal.fire({
        title: 'Submitting...',
        text: 'Please wait while we process your request.',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Submit the form using fetch API
    fetch('SPORTS/submitsportform.php', {
        method: 'POST',
        body: formData // Send form data as POST
    })
    .then(response => response.json()) // Expect a JSON response
    .then(data => {
        Swal.close(); // Close the loading animation

        if (data.success) {
            // Success alert
            Swal.fire({
                title: 'Success!',
                text: data.message || 'Form submitted successfully!',
                icon: 'success'
            }).then(() => {
                form.reset(); // Reset the form inputs

                // Clear file labels and inputs after successful submission
                clearFileInputs();
            });
        } else {
            // Error alert
            Swal.fire({
                title: 'Error!',
                text: data.message || 'Failed to submit the form. Please try again.',
                icon: 'error'
            });
        }
    })
    .catch(error => {
        Swal.close(); // Close the loading animation on error
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'An unexpected error occurred. Please try again later.',
            icon: 'error'
        });
    });
}

// Function to clear file inputs and their labels
function clearFileInputs() {
    // Clear the file input fields
    document.getElementById('psa').value = '';
    document.getElementById('grade').value = '';
    document.getElementById('school-id').value = '';

    // Clear the displayed file names
    document.getElementById('psaFileName').textContent = '';
    document.getElementById('psaFileName').style.display = 'none'; // Hide the label
    document.getElementById('gradeFileName').textContent = '';
    document.getElementById('gradeFileName').style.display = 'none'; // Hide the label
    document.getElementById('schoolIdFileName').textContent = '';
    document.getElementById('schoolIdFileName').style.display = 'none'; // Hide the label
}
</script>
