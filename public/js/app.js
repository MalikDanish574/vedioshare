document.getElementById('login-form').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    if (!email || !password) {
        e.preventDefault();
        alert('Please fill in both email and password.');
    }
});

/* welcome section styles */
// Client-side validation for video upload form
document.getElementById('upload-form')?.addEventListener('submit', function(e) {
    const title = document.getElementById('title').value;
    const video = document.getElementById('video').files[0];
    if (!title || !video) {
        e.preventDefault();
        alert('Please provide a title and select a video file.');
    }
});

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
        fetch(`/videos/${videoId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById(`like-count-${videoId}`).innerText = data.likes;
        })
        .catch(err => console.error('Error:', err));
    });
});