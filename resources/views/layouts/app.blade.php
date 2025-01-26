<?php

use App\Models\Website;

if (env('APP_ENV') == 'local') {
    $website_data = Website::where('id', 1)->first();
} else {
    $website_data = Website::where('slug', Illuminate\Support\Str::after(request()->getHost(), 'www.'))->first();
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MojHub</title>
    <meta name="description" content="MojHub Daily latest video">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="https://devsnews.com/template/bungee/bungee/site.webmanifest/">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('assets/img/favicon.png') }}">

    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <style>
        .header__menu ul li a {
            color: #ffffff;
            padding: 18px 10px;
            line-height: 1;
            font-size: 14px;
            font-family: "Poppins", sans-serif;
            display: block;
            font-weight: 500;
            position: relative;
        }

        .pagination ul li a {
            background: lightblue;
            color: darkblue;
        }

        <?php
        echo $website_data->header_style;
        ?>
    </style>
    <!-- <script> -->
        <?php
        echo $website_data->header_script;
        ?>
    <!-- </script> -->
</head>

<body>

    <header class="header">

        <div class="header__middle pt-10">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-3 d-flex align-items-center justify-content-md-start justify-content-center">
                        <div class="header__logo text-center text-md-left mb-10">
                            <a href="{{ url('/'); }}">
                                <img style="height: 75px;" src="{{ url('assets/moj_hub_logo.png') }}" alt="Mojhub Logo">
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-lg-8 col-md-9">
                        <div class="header__add text-center text-md-right mb-20">
                            <a href="#"><img src="{{ url('assets/img/add/header-add.jpg') }}" alt=""></a>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="header__menu-area black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="header__right-icon f-right mt-17">
                            <a href="#" data-toggle="modal" data-target="#search-modal">
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                        <?php

                        use App\Models\Category;

                        $category_array = Category::where('status', 'active')->get();
                        ?>
                        <div class="header__menu f-left">
                            <nav id="mobile-menu">
                                <ul>
                                    <li class=""><a class="" href="{{ url('/') }}">Home</a></li>
                                    <?php foreach ($category_array as $category_key => $category_item) { ?>
                                        <li><a href="{{ route('category', [$category_item['slug'],1]) }}"><?php echo $category_item['title']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="mobile-menu"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="get" action="{{ route('home') }}">
                        <input type="text" name="s" id="s" placeholder="Search here...">
                        <button>
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->

    <main>

        @yield('content')

    </main>

    <!-- footer -->
    <footer class="footer-bg">

        <div class="copyright-area pt-25 pb-25">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright text-center">
                            <p>© Copyrights <?php echo date('Y'); ?>
                                -
                                <?php
                                echo $website_data->slug;
                                ?>
                                -
                                All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer end -->
    <!-- JS here -->
    <script src="{{ url('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ url('assets/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/js/one-page-nav-min.js') }}"></script>
    <script src="{{ url('assets/js/slick.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ url('assets/js/ajax-form.js') }}"></script>
    <script src="{{ url('assets/js/wow.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ url('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins.js') }}"></script>
    <script src="{{ url('assets/js/main.js') }}"></script>
    <?php
    echo $website_data->footer_script;
    ?>
</body>

</html>