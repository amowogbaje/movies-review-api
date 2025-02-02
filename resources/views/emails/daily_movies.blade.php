<!DOCTYPE html>
<html>
<head>
    <title>New Movies Available</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            width: 100%;
            background: #ffffff;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .movie-card {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
        .movie-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
        .movie-description {
            font-size: 14px;
            color: #555;
            margin: 10px 0;
        }
        .watch-button {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .watch-button:hover {
            background: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }

        /* Responsive Styles */
        @media screen and (max-width: 600px) {
            .container {
                padding: 15px;
                border-radius: 5px;
            }
            .movie-card {
                padding: 12px;
                margin-bottom: 12px;
            }
            .movie-title {
                font-size: 16px;
            }
            .movie-description {
                font-size: 13px;
            }
            .watch-button {
                display: block;
                width: 100%;
                padding: 12px 0;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>🎬 New Movies Added Today 🎬</h2>
        @foreach($movies as $movie)
            <div class="movie-card">
                <div class="movie-title">{{ $movie->title }}</div>
                <div class="movie-description">{{ $movie->description }}</div>
                <a href="{{ url('/movies/'.$movie->id) }}" class="watch-button">Watch Now</a>
            </div>
        @endforeach

        <div class="footer">
            <p>Enjoy your movies! 🍿</p>
            <p>&copy; {{ date('Y') }} Movie Platform</p>
        </div>
    </div>

</body>
</html>
