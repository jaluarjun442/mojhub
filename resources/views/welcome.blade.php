@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="news-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="row pt-30">
                    <?php foreach ($videos as $video): ?>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="postbox mb-10">
                                <div class="postbox__thumb">
                                    <a target="_BLANK" href="{{ route('video_detail', ltrim(parse_url(rtrim($video['slug'], '/'), PHP_URL_PATH), '/')) }}">
                                        <img src="<?php echo $video['thumbnail']; ?>" alt="<?php echo htmlspecialchars($video['title']); ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="postbox__text mb-30">
                                <h4 class="title-16 font-600 pr-0">
                                    <a target="_BLANK" href="{{ route('video_detail', ltrim(parse_url(rtrim($video['slug'], '/'), PHP_URL_PATH), '/')) }}"><?php echo htmlspecialchars($video['title']); ?></a>
                                </h4>
                                <div class="postbox__text-meta pb-10">
                                    <ul>
                                        <li>
                                            <i class="fas fa-clock"></i>
                                            <span><?php echo $video['duration']; ?></span>
                                        </li>
                                        <li>
                                            <i class="fas fa-eye"></i>
                                            <span><?php echo $video['added_on']; ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- <a href="#" class="btn btn-soft">View Video</a> -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row mt-10 mb-60">
                    <div class="col-xl-12 text-center">
                        <form method="GET" action="{{ url()->current() }}" class="page-jump-form">
                            <div class="d-flex align-items-center gap-2 mb-20" style="display: flex !important;flex-direction: row;flex-wrap: nowrap;justify-content: center;align-items: center;">
                                <label for="page_no" class="form-label mb-0">Go To Page: </label>
                                <input
                                    id="page_no"
                                    class="form-control form-control-md col-md-2 ml-10 mr-10"
                                    type="number"
                                    name="page_no"
                                    placeholder="page number"
                                    min="1"
                                    max="{{ $maxPage }}"
                                    required>
                                <button
                                    class="btn btn-primary btn-sm"
                                    type="submit">
                                    Go
                                </button>
                            </div>
                        </form>

                        @if(isset($category_name))
                        <div class="pagination">
                            <ul>
                                @if(isset($page_no))
                                @if($page_no != 1)
                                <li>
                                    <a href="{{ route('category', [$category_name,$page_no-1]) }}">Previous</a>
                                </li>
                                <li>
                                    <a href="{{ route('category', [$category_name,$page_no-1]) }}">{{$page_no-1}}</a>
                                </li>
                                @endif
                                <li class="active">
                                    <a href="#">
                                        <span>{{$page_no}}</span>
                                    </a>
                                </li>
                                @if($page_no != $maxPage && $page_no <= $maxPage)
                                    <li>
                                    <a href="{{ route('category', [$category_name,$page_no+1]) }}">{{$page_no+1}}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('category', [$category_name,$page_no+1]) }}">Next</a>
                                    </li>
                                    ...
                                    <li>
                                        <a href="{{ route('category', [$category_name,$maxPage]) }}">Last({{$maxPage}})</a>
                                    </li>
                                    @endif
                                    @else
                                    <li class="active">
                                        <a href="#">
                                            <span>1</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('category', [$category_name,2]) }}">2</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('category', [$category_name,2]) }}">Next</a>
                                    </li>
                                    ...
                                    <li>
                                        <a href="{{ route('category', [$category_name,$maxPage]) }}">Last({{$maxPage}})</a>
                                    </li>
                                    @endif
                            </ul>
                        </div>
                        @else
                        <div class="pagination">
                            <ul>
                                @if(isset($page_no))
                                @if($page_no != 1)
                                <li>
                                    <a href="{{ route('page', $page_no-1) }}">Previous</a>
                                </li>
                                <li>
                                    <a href="{{ route('page', $page_no-1) }}">{{$page_no-1}}</a>
                                </li>
                                @endif
                                <li class="active">
                                    <a href="#">
                                        <span>{{$page_no}}</span>
                                    </a>
                                </li>
                                @if($page_no != $maxPage && $page_no <= $maxPage)
                                    <li>
                                    <a href="{{ route('page', $page_no+1) }}">{{$page_no+1}}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('page', $page_no+1) }}">Next</a>
                                    </li>
                                    ...
                                    <li>
                                        <a href="{{ route('page', [$maxPage]) }}">Last({{$maxPage}})</a>
                                    </li>
                                    @endif
                                    @else
                                    <li class="active">
                                        <a href="#">
                                            <span>1</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('page', 2) }}">2</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('page', 2) }}">Next</a>
                                    </li>
                                    ...
                                    <li>
                                        <a href="{{ route('page', [$maxPage]) }}">Last({{$maxPage}})</a>
                                    </li>
                                    @endif
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
</section>
@endsection