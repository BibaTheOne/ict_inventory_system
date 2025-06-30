// Show selected tab section
function showSection(sectionId) {
    document.querySelectorAll('.content').forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById(sectionId).style.display = 'block';
}

// Handle tab switching
document.querySelectorAll('.menu a').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('.menu a.active')?.classList.remove('active');
        this.classList.add('active');
        const section = this.getAttribute('href').substring(1);
        showSection(section);
        const url = new URL(window.location);
        url.searchParams.set('tab', section);
        history.pushState(null, '', url);
    });
});

// Load tab from URL or default
window.addEventListener('DOMContentLoaded', () => {
    const tab = new URLSearchParams(window.location.search).get('tab') || 'users';
    const link = document.querySelector(`.menu a[href="#${tab}"]`);
    link?.click();
});

// Search with redirect to page 1
function filterTable(inputId, tableId, section) {
    const search = document.getElementById(inputId).value.trim();
    const url = new URL(window.location);
    url.searchParams.set('tab', section);
    url.searchParams.set('search', search);
    url.searchParams.set('page', 1);
    window.location = url.toString();
}

