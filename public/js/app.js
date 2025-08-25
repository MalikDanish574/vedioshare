document.addEventListener('DOMContentLoaded', function() {
    // Login form validation
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in both email and password.');
            }
        });
    }

    // Client-side validation for video upload form
    const uploadForm = document.getElementById('upload-form');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value;
            const video = document.getElementById('video').files[0];
            if (!title || !video) {
                e.preventDefault();
                alert('Please provide a title and select a video file.');
            }
        });
    }

    // Client-side validation for comment forms
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const content = this.querySelector('input[name="content"]').value;
            if (!content) {
                e.preventDefault();
                alert('Please enter a comment.');
            }
        });
    });

    // Like button functionality
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function() {
            const videoId = this.dataset.id;
            console.log('Like button clicked for video:', videoId); // Debug log
            
            fetch(`/videos/${videoId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                console.log('Response status:', res.status); // Debug log
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Response data:', data); // Debug log
                document.getElementById(`like-count-${videoId}`).innerText = data.likes;
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Failed to like video. Please try again.');
            });
        });
    });
});