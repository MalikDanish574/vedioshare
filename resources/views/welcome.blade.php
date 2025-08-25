<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome to VideoShare</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Poppins:wght@500;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1><span>🎥</span> VideoShare</h1>
            <nav>
                <a href="{{ route('welcome') }}">Home</a>
                <a href="{{ route('explore') }}">Explore</a>
                @auth
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>Share Your Story with VideoShare!</h2>
            <p>Join a vibrant community to create, share, and discover unforgettable moments through video.</p>
            <a href="#upload" class="btn">Start Sharing Now</a>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container main-content" id="upload">
        <!-- Upload Form -->
        @auth
        <div class="video-card">
            <h3>Share Your First Video</h3>
            <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf
                <div class="form-group">
                    <label for="title">Video Title</label>
                    <input type="text" id="title" name="title" placeholder="Give your video a catchy title" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Tell us about your video">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="video">Upload Video</label>
                    <input type="file" id="video" name="video" accept="video/*" required>
                    @error('video')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit">Share Video</button>
            </form>
        </div>
        @else
        <div class="guest-message">
            <p>Please <a href="{{ route('login') }}">log in</a> to share your videos and join the community!</p>
        </div>
        @endauth

        <!-- Community Videos -->
        <h3 class="section-title">Discover Community Videos</h3>
        @forelse ($videos as $video)
            <div class="video-card">
                <div class="video-header">
                    <h4>{{ $video->title }}</h4>
                    <span>{{ $video->created_at->diffForHumans() }}</span>
                </div>
                <p>{{ $video->description }}</p>
                <div class="video-meta">Shared by {{ $video->user->name ?? 'Community Member' }}</div>
                <video controls>
                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="video-actions">
                    @auth
                    <button class="like-button" data-id="{{ $video->id }}">
                        ❤️ <span id="like-count-{{ $video->id }}">{{ $video->likes }}</span>
                    </button>
                    @endauth
                </div>

                <!-- Comments -->
                <div class="comments">
                    <h5>Community Comments</h5>
                    @foreach ($video->comments as $comment)
                        <div class="comment">
                            <div class="comment-header">
                                <strong>{{ $comment->user->name ?? 'Community Member' }}</strong>
                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p>{{ $comment->content }}</p>
                        </div>
                    @endforeach
                    @auth
                    <form action="{{ route('videos.comments.store', $video) }}" method="POST" class="comment-form" id="comment-form-{{ $video->id }}">
                        @csrf
                        <input type="text" name="content" placeholder="Join the conversation..." required>
                        @error('content')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <button type="submit">Comment</button>
                    </form>
                    @endauth
                </div>
            </div>
        @empty
            <p class="no-videos">No videos yet. Be the first to share!</p>
        @endforelse
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>VideoShare &copy; 2025. Connect, Create, Celebrate!</p>
            <div class="footer-links">
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('privacy') }}">Privacy</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>