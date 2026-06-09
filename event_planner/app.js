/**
 * EliteEvents Platform — Client-Side Core Engine
 * Handles real-time search queries, UI state switching, and active session gating.
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize UI Elements DOM Selectors
    const filterButtons = document.querySelectorAll('.filter-pill');
    const eventCards = document.querySelectorAll('.event-card');
    const liveSearchInput = document.getElementById('liveSearchInput');

    // Verify all core interactive elements exist on the current page context
    if (filterButtons.length > 0 && eventCards.length > 0) {
        initializeCategoryFilters(filterButtons, eventCards);
    }

    if (liveSearchInput && eventCards.length > 0) {
        initializeLiveSearch(liveSearchInput, eventCards);
    }
});

/**
 * Filter Engine: Handles switching tabs and filtering cards via data-attributes
 */
function initializeCategoryFilters(buttons, cards) {
    buttons.forEach(pill => {
        pill.addEventListener('click', () => {
            // Remove active visual class states from all matching nodes
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Apply active class style state to the chosen pill clicked by the user
            pill.classList.add('active');

            const selectedFilter = pill.getAttribute('data-filter');

            cards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                
                // Toggle element block states cleanly depending on matches found
                if (selectedFilter === 'all' || cardCategory === selectedFilter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

/**
 * Search Engine: Parses titles and locations instantly without page refreshes
 */
function initializeLiveSearch(inputElement, cards) {
    inputElement.addEventListener('input', (event) => {
        const queryValue = event.target.value.toLowerCase().trim();

        cards.forEach(card => {
            const titleText = card.querySelector('.card-title').textContent.toLowerCase();
            const locationText = card.querySelector('.card-loc').textContent.toLowerCase();

            // Evaluate if search term patterns overlap with core card details
            if (titleText.includes(queryValue) || locationText.includes(queryValue)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

/**
 * Gatekeeper Booking Function: Manages transactional workflows
 * @param {number} eventId - Unique structural integer ID referencing specific rows in MySQL
 * @param {boolean} isLoggedIn - Injected parameter status determining user session security paths
 */
function book(eventId, isLoggedIn) {
    if (isLoggedIn) {
        // Advanced Next Step: You would make an AJAX Fetch/Axios call to create a booking record here.
        alert(`Access Granted! Routing you securely to payment checkout pipelines for Event ID: [${eventId}].`);
    } else {
        alert("Authentication Required! Redirecting to our sign-in portal to safeguard ticket registrations.");
        window.location.href = "login.php";
    }
}


document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    if (passwordInput && strengthBar && strengthText) {
        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            let score = 0;

            if (!val) {
                strengthBar.style.width = '0%';
                strengthText.textContent = '';
                return;
            }

           
            if (val.length >= 6) score++; // Length check
            if (/[A-Z]/.test(val)) score++; // Contains uppercase
            if (/[0-9]/.test(val)) score++; // Contains numbers
            if (/[^A-Za-z0-9]/.test(val)) score++; // Contains special characters

            
            if (score <= 1) {
                strengthBar.style.width = '25%';
                strengthBar.style.background = '#f87171'; // Pastel red
                strengthText.textContent = 'Weak password 🍓';
                strengthText.style.color = '#f87171';
            } else if (score === 2) {
                strengthBar.style.width = '50%';
                strengthBar.style.background = '#fbbf24'; // Pastel yellow
                strengthText.textContent = 'Getting better 🍯';
                strengthText.style.color = '#fbbf24';
            } else if (score === 3) {
                strengthBar.style.width = '75%';
                strengthBar.style.background = '#60a5fa'; // Pastel blue
                strengthText.textContent = 'Strong password 🧊';
                strengthText.style.color = '#60a5fa';
            } else if (score === 4) {
                strengthBar.style.width = '100%';
                strengthBar.style.background = '#34d399'; // Pastel mint green
                strengthText.textContent = 'Perfect security! 🌸✨';
                strengthText.style.color = '#34d399';
            }
        });
    }
});