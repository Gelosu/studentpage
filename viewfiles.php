<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploaded Files</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        a {
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Uploaded Files</h2>
    <div id="fileTableContainer">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Sport</th>
                    <th>PSA</th>
                    <th>Grade Photo Copy</th>
                    <th>School ID</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody id="fileTableBody">
                <!-- Rows will be populated dynamically -->
            </tbody>
        </table>
    </div>

    <script>
        // Fetch and display files from the database
        function fetchFiles() {
            fetch('fetchfiles.php') // Your PHP file
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const files = data.data;
                        const tableBody = document.getElementById('fileTableBody');
                        tableBody.innerHTML = ''; // Clear existing rows

                        // Populate table with files
                        files.forEach(file => {
                            const row = `
                                <tr>
                                    <td>${file.ID}</td>
                                    <td>${file.NAME}</td>
                                    <td>${file.SECTION}</td>
                                    <td>${file.SPORT}</td>
                                    <td><a href="${file.PSA_PATH}" target="_blank">View PSA</a></td>
                                    <td><a href="${file.GRADEPATH}" target="_blank">View Grade Copy</a></td>
                                    <td><a href="${file.IDPATH}" target="_blank">View School ID</a></td>
                                    <td>${file.UPLOADDT}</td>
                                </tr>
                            `;
                            tableBody.innerHTML += row; // Append row to table
                        });
                    } else {
                        alert(data.message || 'No files found.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching files:', error);
                    alert('An error occurred while fetching files.');
                });
        }

        // Fetch files on page load
        document.addEventListener('DOMContentLoaded', fetchFiles);
    </script>
</body>
</html>
