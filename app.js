const toggleBtn = document.getElementById('toggle-btn');
        let isDarkMode = false;

        toggleBtn.addEventListener('click', function() {
            if (isDarkMode) {
                document.body.style.backgroundColor = 'white';
                document.querySelector('.welcome-text').style.color = '#000';
            } else {
                document.body.style.backgroundColor = '#333'; /* Dark grey color */
                document.querySelector('.welcome-text').style.color = '#fff';
            }
            isDarkMode = !isDarkMode;
        });