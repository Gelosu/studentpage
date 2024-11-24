<section>
    <h2>The Guidance Services and Career Development</h2>

    <!-- Buttons to choose form type -->
    <div id="formSelection">
        <button id="appointmentButton">Appointment Form</button>
        <button id="leaveButton">Leave of Absence Form</button>
    </div>

    <!-- Appointment Form -->
    
    <div id="appointmentForm" style="display: none; margin-top: 20px; ">
    <div id="backToSelectionFromAppointment" class="image-button">
    <img src="assets/img/BACK.png" alt="Back" class="button-image">
</div>
        <h3>Appointment Form</h3>
       

        <form id="appointmentFormElement" onsubmit="submitAppointmentForm(event)">
            <input type="hidden" name="formType" value="appointment">
            <label for="studentName">Name:</label><br>
            <input type="text" id="studentName" name="studentName" placeholder="Enter your name" required><br>

            <label for="section">Section:</label><br>
            <input type="text" id="section" name="section" placeholder="Enter your section" required><br>

            <label for="counselor">Counselor:</label><br>
            <input type="text" id="counselor" name="counselor" placeholder="Enter counselor's name" required><br>

            <label for="date">Date:</label><br>
            <input type="date" id="date" name="date" required><br>

            <label for="time">Time:</label><br>
            <input type="time" id="time" name="time" required><br>

            <label for="message">Message:</label><br>
            <textarea id="message" name="message" placeholder="Enter your message" required></textarea><br>

            <button type="submit">Submit Appointment</button>
        </form>
        
    </div>

    <div id="leaveForm" style="display: none; margin-top: 20px;">
    <div id="backToSelectionFromLeave" class="image-button">
        <img src="assets/img/BACK.png" alt="Back" class="button-image">
    </div>
    <h3>Leave of Absence Form</h3>
    <form id="leaveFormElement" onsubmit="submitLeaveForm(event)">
        <input type="hidden" name="formType" value="leave">
        
        <label for="studentName">Name:</label><br>
        <input type="text" id="studentName" name="studentName" placeholder="Enter your name" required><br>

        <label for="section">Section, Course, and Year:</label><br>
        <input type="text" id="section" name="section" placeholder="Enter your section, course, and year" required><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br>

        <label for="interviewDate">Date of Interview:</label><br>
        <input type="date" id="interviewDate" name="interviewDate" required><br>

        <label for="leaveStart">Date of Leave to Start:</label><br>
        <input type="date" id="leaveStart" name="leaveStart" required><br>

        <label for="reason">Reason for Leave of Absence:</label><br>
        <textarea id="reason" name="reason" placeholder="Enter your reason" required></textarea><br>

        <button type="submit">Submit Leave of Absence</button>
    </form>
</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
 
     // Handle form selection
     const appointmentButton = document.getElementById('appointmentButton');
    const leaveButton = document.getElementById('leaveButton');
    const appointmentForm = document.getElementById('appointmentForm');
    const leaveForm = document.getElementById('leaveForm');
    const formSelection = document.getElementById('formSelection');
    const backToSelectionFromAppointment = document.getElementById('backToSelectionFromAppointment');
    const backToSelectionFromLeave = document.getElementById('backToSelectionFromLeave');

    appointmentButton.addEventListener('click', () => {
        formSelection.style.display = 'none';
        appointmentForm.style.display = 'block';
    });

    leaveButton.addEventListener('click', () => {
        formSelection.style.display = 'none';
        leaveForm.style.display = 'block';
    });

    backToSelectionFromAppointment.addEventListener('click', () => {
        appointmentForm.style.display = 'none';
        formSelection.style.display = 'block';
    });

    backToSelectionFromLeave.addEventListener('click', () => {
        leaveForm.style.display = 'none';
        formSelection.style.display = 'block';
    });

    function submitAppointmentForm(event) {
    event.preventDefault(); // Prevent default form submission

    const form = document.getElementById("appointmentFormElement");
    const formData = new FormData(form);

    // Display loading SweetAlert
    Swal.fire({
        title: "Submitting...",
        text: "Please wait while we process your request.",
        icon: "info",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    // Submit the form data using fetch
    fetch("GUIDANCE SERVICES/submitapptstud.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) // Expect JSON response from server
        .then((data) => {
            Swal.close(); // Close the loading alert

            if (data.success) {
                // Success SweetAlert
                Swal.fire({
                    title: "Success!",
                    text: data.message || "Appointment submitted successfully.",
                    icon: "success",
                }).then(() => {
                    // Optionally, reset the form or perform additional actions
                    form.reset();
                });
            } else {
                // Failure SweetAlert
                Swal.fire({
                    title: "Error!",
                    text: data.message || "Failed to submit the appointment. Please try again.",
                    icon: "error",
                });
            }
        })
        .catch((error) => {
            Swal.close(); // Close the loading alert
            console.error("Error:", error);
            Swal.fire({
                title: "Error!",
                text: "An unexpected error occurred. Please try again later.",
                icon: "error",
            });
        });
}

function submitLeaveForm(event) {
    event.preventDefault(); // Prevent default form submission

    const form = document.getElementById("leaveFormElement");
    const formData = new FormData(form);

    // Show SweetAlert for loading
    Swal.fire({
        title: "Submitting...",
        text: "Please wait while we process your request.",
        icon: "info",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    // Submit the form data using fetch
    fetch("GUIDANCE SERVICES/submitloa.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) // Expect JSON response from server
        .then((data) => {
            Swal.close(); // Close the loading alert

            if (data.success) {
                // Success SweetAlert
                Swal.fire({
                    title: "Success!",
                    text: data.message || "Leave of Absence submitted successfully.",
                    icon: "success",
                }).then(() => {
                    // Optionally, reset the form
                    form.reset();
                });
            } else {
                // Failure SweetAlert
                Swal.fire({
                    title: "Error!",
                    text: data.message || "Failed to submit the Leave of Absence. Please try again.",
                    icon: "error",
                });
            }
        })
        .catch((error) => {
            Swal.close(); // Close the loading alert
            console.error("Error:", error);
            Swal.fire({
                title: "Error!",
                text: "An unexpected error occurred. Please try again later.",
                icon: "error",
            });
        });
}


</script>
