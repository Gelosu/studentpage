<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/kld.logo.png">
    <title>Kolehiyo ng Dasmariñas</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="style.css">
    <script>
        // Function to set and activate the desired section based on navigation clicks
        function setActiveSection(sectionId) {
            window.location.hash = sectionId;  
            toggleSection(sectionId); // Toggle visibility of the selected section
        }

        // Function to toggle visibility of sections
        function toggleSection(sectionId) {
            var sections = document.querySelectorAll('.section');
            sections.forEach(function(section) {
                if (section.id === sectionId) {
                    section.style.display = 'block'; // Show the active section
                } else {
                    section.style.display = 'none'; // Hide other sections
                }
            });
        }

        // Show default section (e.g., HOME) when page loads
        document.addEventListener('DOMContentLoaded', function () {
            toggleSection('home');
        });
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/img/kld.logo.png" alt="Logo"> 
            <span>KOLEHIYO NG DASMARINAS</span>
        </div>
        <nav>
            <a href="#" onclick="setActiveSection('home')">HOME</a>
            <a href="#" onclick="setActiveSection('about')">ABOUT</a>
            <div class="dropdown">
                <a href="#">UNITS</a>
                <div class="dropdown-content">
                    <a href="#" onclick="setActiveSection('guidance')">GUIDANCE SERVICES AND CAREER DEVELOPMENT</a>
                    <a href="#" onclick="setActiveSection('welfare')">CHARACTER FORMATION AND WELFARE DEVELOPMENT</a>
                    <a href="#" onclick="setActiveSection('studacts')">STUDENT ACTIVITIES AND DEVELOPMENT</a>
                    <a href="#" onclick="setActiveSection('sports')">SPORTS AND WELLNESS DEVELOPMENT</a>
                    <a href="#" onclick="setActiveSection('studpubs')">STUDENT PUBLICATIONS</a>
                    
                </div>
            </div>
            <div class ="dropdown">
                <a href="#">LOGIN</a>
                <div class ="dropdown-content">
                    <a href="HEALTHLOGIN/index.php">LOGIN FOR HEALTH</a>
                    <a href="PUBLICATIONLOGIN/login.php">LOGIN FOR PUBLICATION</a>
                </div>
            </div>
            
        </nav>
    </header>

    <!-- Section Content -->
    <div id="home" class="section">
    <div class="main-content">
    <div class="full-width-bg">
        <h1>INSTITUTE OF STUDENT AFFAIRS, CHARACTER EDUCATION AND CITIZENSHIP (ISACEC)</h1>
    </div>
</div>
    </div>

    <div id="about" class="section" style="display: none;">
        <h1>About Us</h1>
        <p>About Section Content</p>
    </div>

    <div id="guidance" class="section" style="display: none;">
    <?php include 'GUIDANCE SERVICES/guidserv.php'; ?>
        
    </div>

    <div id="welfare" class="section" style="display: none;">
        <h1>Character Formation and Welfare Development</h1>
        <p>Welfare Section Content</p>
    </div>

    <div id="studacts" class="section" style="display: none;">
        <h1>Student Activities and Development</h1>
        <p>Student Activities Section Content</p>
    </div>

    <div id="sports" class="section" style="display: none;">
    <?php include 'SPORTS/sport.php'; ?>
    </div>

    <div id="studpubs" class="section" style="display: none;">
    <?php include 'STUDPUBS/studpubs.php'; ?>
    </div>
</body>
</html>
