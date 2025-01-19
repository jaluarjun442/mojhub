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
                        <h2 class="details-title mb-15">
                            <?php echo htmlspecialchars($video['title']); ?>
                        </h2>

                        <div class="postbox__text mb-30">
                            <div class="post-thumb mb-25">
                                <video id="video-id" class="video-player" controls>
                                    <source src="<?php echo $video['download_url']; ?>" type="video/mp4" />
                                </video>
                            </div>
                            <!-- <a href="#" class="btn btn-soft">View Video</a> -->
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
                "fillToContainer": false,
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
@endsection