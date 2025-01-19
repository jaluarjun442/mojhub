<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video List</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Video List</h1>
    <div class="video-container">
        <?php foreach ($videos as $video): ?>
            <div class="video-card">
                <a href="{{ route('video_detail', ltrim(parse_url(rtrim($video['url'], '/'), PHP_URL_PATH), '/')) }}" class="video-link">
                    <div class="video-thumb">
                        <img src="<?php echo $video['thumbnail']; ?>" alt="<?php echo htmlspecialchars($video['title']); ?>" />
                    </div>
                    <div class="video-info">
                        <h2 class="video-title"><?php echo htmlspecialchars($video['title']); ?></h2>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
        @if(isset($page_no))
        @if($page_no != 1)
        <a href="{{ route('page', $page_no-1) }}" class="video-link">Next</a>
        @endif
        -
        {{$page_no}}
        -
        <a href="{{ route('page', $page_no+1) }}" class="video-link">Next</a>
        @else
        1 -
        <a href="{{ route('page', 2) }}" class="video-link">Next</a>
        @endif
    </div>
</body>

</html>