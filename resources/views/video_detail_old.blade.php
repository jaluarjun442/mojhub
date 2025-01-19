
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Details - <?php echo htmlspecialchars($video_detail['title']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Video Detail</h1>

    <div class="video-player-container">
        <video controls>
            <source src="<?php echo $video_detail['download_url']; ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <h2><?php echo htmlspecialchars($video_detail['title']); ?></h2>

    <div class="downLink" align="center">
        <a class="btn download-btn" href="<?php echo $video_detail['download_url']; ?>" target="_blank">
            <b>Download Clip</b>
        </a>
    </div>

    <div class="back-link" align="center">
        <a href="index.php" class="btn back-btn">Back to Video List</a>
    </div>
</body>
</html>
