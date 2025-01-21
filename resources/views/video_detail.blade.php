@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>
    /* Make the video take the full width */
    .video-player {
        width: 100%;
        height: auto;
        /* Maintain aspect ratio */
        max-width: 100%;
        /* Prevents overflow */
    }

    /* Ensure it works well on mobile screens */
    @media (max-width: 767px) {
        .video-player {
            width: 100%;
            height: auto;
        }
    }
</style>
<section class="news-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="row pt-10">
                    <div class="col-xl-12 col-lg-12 col-md-12">

                        <div class="postbox__text mb-30 row">
                            <div class="post-thumb mb-25 col-xl-12 col-lg-12 col-md-12">
                                <video id="video-id" class="video-player fluid-player" controls>
                                    <source src="<?php echo $video['download_url']; ?>" type="video/mp4" />
                                </video>
                            </div>
                            <!-- <a href="#" class="btn btn-soft">View Video</a> -->
                        </div>
                        <h2 class="details-title mb-15">
                            <?php echo htmlspecialchars($video['title']); ?>
                        </h2>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="row pt-10">
                            <?php
                            if (count($video['related_videos']) > 0) {
                                foreach ($video['related_videos'] as $video): ?>
                                    <div class="col-xl-4 col-lg-4 col-md-4">
                                        <div class="postbox mb-10">
                                            <div class="postbox__thumb">
                                                <a target="_BLANK" href="{{ route('video_detail', ltrim(parse_url(rtrim($video['url'], '/'), PHP_URL_PATH), '/')) }}">
                                                    <img src="<?php echo $video['thumbnail']; ?>" alt="<?php echo htmlspecialchars($video['title']); ?>">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="postbox__text mb-30">
                                            <h4 class="title-16 font-600 pr-0">
                                                <a target="_BLANK" href="{{ route('video_detail', ltrim(parse_url(rtrim($video['url'], '/'), PHP_URL_PATH), '/')) }}"><?php echo htmlspecialchars($video['title']); ?></a>
                                            </h4>
                                            <div class="postbox__text-meta pb-10">
                                                <ul>
                                                    <li>
                                                        <i class="fas fa-clock"></i>
                                                        <span><?php echo $video['time']; ?></span>
                                                    </li>
                                                    <li>
                                                        <i class="fas fa-eye"></i>
                                                        <span><?php echo $video['view']; ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- <a href="#" class="btn btn-soft">View Video</a> -->
                                        </div>
                                    </div>
                            <?php endforeach;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
    </div>
</section>

<script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>

<script>
    var myFP = fluidPlayer(
        'video-id', {
            "layoutControls": {
                "controlBar": {
                    "autoHideTimeout": 3,
                    "animated": true,
                    "autoHide": true
                },
                "htmlOnPauseBlock": {
                    "html": "",
                    "height": null,
                    "width": null
                },
                "autoPlay": false,
                "mute": true,
                "playPauseAnimation": true,
                "playbackRateEnabled": true,
                "allowDownload": true,
                "playButtonShowing": true,
                "fillToContainer": true,
                "primaryColor": "blue",
                "posterImage": ""
            },
            "vastOptions": {
                "adList": [],
                "adCTAText": false,
                "adCTATextPosition": ""
            }
        });
</script>
<style>
    .fluid-player {
        width: 100%;
        height: 100vh;
    }

    @media (max-width: 768px) {
        .fluid-player {
            height: auto;
            max-height: 100vh;
        }
    }

    @media (min-width: 768px) {
        .fluid-player {
            max-height: 70vh;
        }
    }
</style>
@endsection