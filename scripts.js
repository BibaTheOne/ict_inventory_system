// Function to switch between sections
function showSection(sectionId) {
    const sections = document.querySelectorAll('.content');
    sections.forEach(section => {
        section.style.display = 'none'; // Hide all sections
    });
    document.getElementById(sectionId).style.display = 'block'; // Show selected section
}

// Event listeners for menu items
document.querySelectorAll('.menu a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default anchor behavior
        document.querySelector('.menu a.active').classList.remove('active'); // Remove active class from current
        this.classList.add('active'); // Add active class to clicked link
        showSection(this.getAttribute('href').substring(1)); // Show section based on href
    });
});

// Initialize the dashboard to show the users section
showSection('users');
