<!DOCTYPE html>
<html>
<head>
    <title>New Movies Available</title>
</head>
<body>
    <h2>New Movies Added Today</h2>
    <ul>
        @foreach($movies as $movie)
            <li>
                <strong>{{ $movie->title }}</strong><br>
                {{ $movie->description }}<br>
                <a href="{{ url('/movies/'.$movie->id) }}">Watch Now</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
