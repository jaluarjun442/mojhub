<?php

use App\Models\Website;

if (env('APP_ENV') == 'local') {
    $website_data = Website::where('id', 1)->first();
} else {
    $website_data = Website::where('slug', Illuminate\Support\Str::after(request()->getHost(), 'www.'))->first();
}
?>
<div class="col-xl-4 col-lg-4">
    <?php
    echo $website_data->sidebar;
    ?>
</div>
<!-- <div class="col-xl-4 col-lg-4">
    <div class="widget mb-40">
        <a href="#">
            <img src="{{ url('assets/img/add/add-sidebar.jpg') }}" alt="">
        </a>
    </div>
    <div class="widget widget-border mb-40">
        <h3 class="widget-title">Popular posts</h3>
    </div>
    <div class="post__small mb-30">
        <div class="post__small-thumb f-left">
            <a href="#">
                <img src="{{ url('assets/img/trendy/xs/xs-1.jpg') }}" alt="hero image">
            </a>
        </div>
        <div class="post__small-text fix pl-10">
            <span class="sm-cat">
                <a href="#">Fashion</a>
            </span>
            <h4 class="title-13 pr-0">
                <a href="#">Husar asks expenses authority to entitlements after Bruno</a>
            </h4>
            <div class="post__small-text-meta">
                <ul>
                    <li>
                        <i class="fas fa-calendar-alt"></i>
                        <span>01 Sep 2018</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post__small mb-30">
        <div class="post__small-thumb f-left">
            <a href="#">
                <img src="{{ url('assets/img/trendy/xs/xs-2.jpg') }}" alt="hero image">
            </a>
        </div>
        <div class="post__small-text fix pl-10">
            <span class="sm-cat">
                <a href="#">Fashion</a>
            </span>
            <h4 class="title-13 pr-0">
                <a href="#">Researchers claim majo throug in the fight to cure fibrosis</a>
            </h4>
            <div class="post__small-text-meta">
                <ul>
                    <li>
                        <i class="fas fa-calendar-alt"></i>
                        <span>01 Sep 2018</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post__small mb-30">
        <div class="post__small-thumb f-left">
            <a href="#">
                <img src="{{ url('assets/img/trendy/xs/xs-3.jpg') }}" alt="hero image">
            </a>
        </div>
        <div class="post__small-text fix pl-10">
            <span class="sm-cat">
                <a href="#">Fashion</a>
            </span>
            <h4 class="title-13 pr-0">
                <a href="#">Nahan downplays Liberal lership tensions after white ant</a>
            </h4>
            <div class="post__small-text-meta">
                <ul>
                    <li>
                        <i class="fas fa-calendar-alt"></i>
                        <span>01 Sep 2018</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post__small">
        <div class="post__small-thumb f-left">
            <a href="#">
                <img src="{{ url('assets/img/trendy/xs/xs-4.jpg') }}" alt="hero image">
            </a>
        </div>
        <div class="post__small-text fix pl-10">
            <span class="sm-cat">
                <a href="#">Travel</a>
            </span>
            <h4 class="title-13 pr-0">
                <a href="#">Farmers plead for bullets to put down emaciated stock</a>
            </h4>
            <div class="post__small-text-meta">
                <ul>
                    <li>
                        <i class="fas fa-calendar-alt"></i>
                        <span>01 Sep 2018</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> -->