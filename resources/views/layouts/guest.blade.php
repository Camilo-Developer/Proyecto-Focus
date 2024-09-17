<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') | Focus</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link href="{{asset('vendor/lightgallery/css/lightgallery.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/switcher/switcher.css')}}">
    <link href="{{asset('vendor/Splitting/dist/Splitting.css')}}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{asset('vendor/rangeslider/rangeslider.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" class="skin" href="{{asset('css/skin/skin-2.css')}}">

</head>

<body id="bg" style="overflow-x: hidden;">
    <div id="loading-area" class="loading-page-1">
        <div class="spinner">
            <div class="ball"></div>
            <p>LOADING</p>
        </div>
    </div>
    <div class="page-wraper">
        <!-- Header -->
        <header class="site-header mo-left header style-1">

            <!-- Main Header -->
            <div class="sticky-header main-bar-wraper navbar-expand-lg">
                <div class="main-bar clearfix ">
                    <div class="container clearfix">
                        <!-- Website Logo -->
                        <div class="logo-header mostion logo-dark">
                            <a href="index.html"><img src="images/logo-2.png" alt=""></a>
                        </div>
                        <!-- Nav Toggle Button -->
                        <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
                            data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <!-- Extra Nav -->
                        <div class="extra-nav">
                            <div class="extra-cell">
                                <a title="Iniciar sesión" href="{{route('login')}}"
                                    class="btn btn-primary light phone-no shadow-none effect-1"><span><i
                                            class="fas fa-user shake"></i>Iniciar sesión</span></a>
                            </div>
                        </div>
                        <!-- Extra Nav -->
                        <div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
                            <div class="logo-header logo-dark">
                                <a href="index.html"><img src="images/logo-2.png" alt=""></a>
                            </div>
                            <ul class="nav navbar-nav navbar navbar-left">
                                <li><a href="{{route('inicio')}}">INICIO</a></li>

                                <li class="sub-menu-down"><a href="javascript:void(0);">SHOP<i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="shop.html">SHOP</a></li>
                                        <li><a href="shop-detail.html">SHOP DETAIL</a></li>
                                        <li><a href="shop-cart.html">CART</a></li>
                                        <li><a href="add-list.html">ADD LIST</a></li>
                                        <li><a href="shop-checkout.html">CHECKOUT</a></li>
                                        <li><a href="shop-wishlist.html">WISHLIST</a></li>
                                    </ul>
                                </li>

                                <li class="sub-menu-down"><a href="javascript:void(0);">LISTINGS<i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="property-listing.html">PROPERTY LISTING</a>
                                        </li>
                                        <li>
                                            <a href="property-service.html">DEALERS & SERVICE</a>
                                        </li>
                                        <li>
                                            <a href="property-details.html">PROPERTY DETAIL</a>
                                        </li>
                                        <li>
                                            <a href="popular-property.html">POPULAR PROPERTY</a>
                                        </li>
                                        <li>
                                            <a href="property-serach.html">SEARCH PROPERTY</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sub-menu-down"><a href="javascript:void(0);">BLOG<i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="blog-grid.html">BLOG GRID</a></li>
                                        <li><a href="blog-list-sidebar.html">BLOST LIST SIDEBAR</a></li>
                                        <li><a href="blog-details.html">BLOG DETAIL</a></li>
                                    </ul>
                                </li>
                                <li class="sub-menu-down"><a href="javascript:void(0);">PAGES<i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="about-us.html">ABOUT</a></li>
                                        <li><a href="team.html">TEAM</a></li>
                                        <li><a href="team-detail.html">TEAM DETAIL</a></li>
                                        <li><a href="location.html">LOCATION</a></li>
                                        <li><a href="error-404.html">ERROR 404<span class="badge">New</span></a></li>
                                        <li><a href="faqs.html">FAQ</a></li>
                                        <li><a href="pricing.html">PRICING TABEL</a></li>
                                        <li><a href="testimonial.html">TESTIMONIAL</a></li>
                                        <li><a href="privacy-policy.html">PRIVACY-POLICY</a></li>
                                        <li class="extra-menu">
                                            <a href="#">PORTFOLIO<i class="fa fa-angle-down"></i></a>
                                            <ul class="sub-menu-2">
                                                <li><a href="portfolio.html">PORTFOLIO</a></li>
                                                <li><a href="portfolio-detail.html">PORTFOLIO DETAIL</a></li>
                                            </ul>
                                        </li>
                                        <li class="extra-menu">
                                            <a href="#">SERVICE<i class="fa fa-angle-down"></i></a>
                                            <ul class="sub-menu-2">
                                                <li><a href="services.html">SERVICES</a></li>
                                                <li><a href="service-detail.html">SERVICE DETAIL</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="contact-us.html">CONTACT</a>
                                </li>
                            </ul>
                            <div class="ic-social-icon">
                                <ul>
                                    <li><a class="fab fa-facebook-f" href="javascript:void(0);"></a></li>
                                    <li><a class="fab fa-twitter" href="javascript:void(0);"></a></li>
                                    <li><a class="fab fa-linkedin-in" href="javascript:void(0);"></a></li>
                                    <li><a class="fab fa-instagram" href="javascript:void(0);"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Header End -->
        </header>
        <!-- Header End -->


        <div class="page-content bg-white">
            @yield('content')
        </div>
      
        <!-- Footer -->
        <footer class="site-footer style-1" id="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                            <div class="widget widget_about">
                                <div class="footer-logo">
                                    <img src="images/logo-2.png" alt="">
                                </div>
                                <h5 class="m-b20">Best real estate house</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua.</p>
                                <ul class="social-list style-1">
                                    <li><a href="https://www.youtube.com/" target="_blank"><i
                                                class="fab fa-youtube"></i></a></li>
                                    <li><a href="https://www.linkedin.com/" target="_blank"><i
                                                class="fab fa-linkedin"></i></a></li>
                                    <li><a href="https://twitter.com/" target="_blank"><i
                                                class="fab fa-twitter"></i></a></li>
                                    <li><a href="https://www.facebook.com/" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="https://www.instagram.com/" target="_blank"><i
                                                class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget widget_categories p-l50">
                                <div class="widget-title">
                                    <h5 class="title">Quick Links</h5>
                                </div>
                                <ul>
                                    <li class="cat-item"><a href="about-us.html">About us</a></li>
                                    <li class="cat-item"><a href="contact-us.html">Contact us</a></li>
                                    <li class="cat-item"><a href="property-listing.html">Products</a></li>
                                    <li class="cat-item"><a href="javascript:void(0);">Login</a></li>
                                    <li class="cat-item"><a href="javascript:void(0);">Sign Up</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget widget_categories">
                                <div class="widget-title">
                                    <h5 class="title">Support</h5>
                                </div>
                                <ul>
                                    <li class="cat-item"><a href="javascript:void(0);">Affiliates</a></li>
                                    <li class="cat-item"><a href="javascript:void(0);">Sitemap</a></li>
                                    <li class="cat-item"><a href="javascript:void(0);">Cancelation Policy</a></li>
                                    <li class="cat-item"><a href="javascript:void(0);">Privacy Policy</a></li>
                                    <li class="cat-item"><a href="javascript:void(0);">Legal Disclaimer</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h5 class="title">Contact</h5>
                                </div>
                                <div class="icon-bx-wraper style-2 m-b20">
                                    <div class="icon-bx-sm radius">
                                        <span class="icon-cell">
                                            <svg width="23" height="25" viewBox="0 0 23 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21.6675 23.3511H20.6854V1.97607C20.6854 1.35475 20.1578 0.851074 19.5068 0.851074H3.00684C2.35592 0.851074 1.82826 1.35475 1.82826 1.97607V23.3511H0.846122C0.520689 23.3511 0.256836 23.6029 0.256836 23.9136V24.8511H22.2568V23.9136C22.2568 23.6029 21.993 23.3511 21.6675 23.3511ZM6.54255 4.41357C6.54255 4.10293 6.8064 3.85107 7.13184 3.85107H9.09612C9.42155 3.85107 9.68541 4.10293 9.68541 4.41357V6.28857C9.68541 6.59922 9.42155 6.85107 9.09612 6.85107H7.13184C6.8064 6.85107 6.54255 6.59922 6.54255 6.28857V4.41357ZM6.54255 8.91357C6.54255 8.60293 6.8064 8.35107 7.13184 8.35107H9.09612C9.42155 8.35107 9.68541 8.60293 9.68541 8.91357V10.7886C9.68541 11.0992 9.42155 11.3511 9.09612 11.3511H7.13184C6.8064 11.3511 6.54255 11.0992 6.54255 10.7886V8.91357ZM9.09612 15.8511H7.13184C6.8064 15.8511 6.54255 15.5992 6.54255 15.2886V13.4136C6.54255 13.1029 6.8064 12.8511 7.13184 12.8511H9.09612C9.42155 12.8511 9.68541 13.1029 9.68541 13.4136V15.2886C9.68541 15.5992 9.42155 15.8511 9.09612 15.8511ZM12.8283 23.3511H9.68541V19.4136C9.68541 19.1029 9.94926 18.8511 10.2747 18.8511H12.239C12.5644 18.8511 12.8283 19.1029 12.8283 19.4136V23.3511ZM15.9711 15.2886C15.9711 15.5992 15.7073 15.8511 15.3818 15.8511H13.4176C13.0921 15.8511 12.8283 15.5992 12.8283 15.2886V13.4136C12.8283 13.1029 13.0921 12.8511 13.4176 12.8511H15.3818C15.7073 12.8511 15.9711 13.1029 15.9711 13.4136V15.2886ZM15.9711 10.7886C15.9711 11.0992 15.7073 11.3511 15.3818 11.3511H13.4176C13.0921 11.3511 12.8283 11.0992 12.8283 10.7886V8.91357C12.8283 8.60293 13.0921 8.35107 13.4176 8.35107H15.3818C15.7073 8.35107 15.9711 8.60293 15.9711 8.91357V10.7886ZM15.9711 6.28857C15.9711 6.59922 15.7073 6.85107 15.3818 6.85107H13.4176C13.0921 6.85107 12.8283 6.59922 12.8283 6.28857V4.41357C12.8283 4.10293 13.0921 3.85107 13.4176 3.85107H15.3818C15.7073 3.85107 15.9711 4.10293 15.9711 4.41357V6.28857Z"
                                                    fill="white"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="icon-content">
                                        <p>77 Highfield Road London N36 7SB</p>
                                    </div>
                                </div>
                                <div class="icon-bx-wraper style-2">
                                    <div class="icon-bx-sm radius">
                                        <span class="icon-cell">
                                            <svg width="22" height="24" viewBox="0 0 22 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21.3722 16.9589L16.5597 14.7089C16.3541 14.6134 16.1257 14.5932 15.9087 14.6515C15.6917 14.7099 15.4979 14.8435 15.3566 15.0324L13.2254 17.873C9.88055 16.1526 7.18876 13.2161 5.61172 9.56722L8.21562 7.24222C8.38908 7.08832 8.51185 6.87696 8.56535 6.64014C8.61884 6.40331 8.60015 6.15392 8.51211 5.92972L6.44961 0.67973C6.35298 0.438047 6.18207 0.240721 5.96636 0.121777C5.75065 0.00283366 5.50366 -0.0302721 5.26797 0.0281687L0.799219 1.15317C0.571987 1.21041 0.36925 1.34999 0.224097 1.54911C0.0789444 1.74824 -5.2345e-05 1.99516 2.60228e-08 2.24957C2.60228e-08 14.273 8.9332 23.9995 19.9375 23.9995C20.1708 23.9997 20.3972 23.9136 20.5799 23.7552C20.7625 23.5969 20.8905 23.3756 20.943 23.1277L21.9742 18.2527C22.0274 17.9943 21.9965 17.7238 21.8866 17.4877C21.7767 17.2515 21.5948 17.0646 21.3722 16.9589Z"
                                                    fill="white"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="icon-content">
                                        <p>+91 987 654 3210 </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="container">
                    <div class="row align-items-center fb-inner spno">
                        <div class="col-12 text-center">
                            <span class="copyright-text">Copyright © <span class="current-year">2024</span> <a
                                    href="#" target="_blank">Focus</a>. All rights
                                reserved.</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->
        <button class="scroltop icon-up" type="button"><i class="fas fa-arrow-up"></i></button>
    </div>
    <!-- JAVASCRIPT FILES ========================================= -->
    <script src="{{asset('js/jquery.min.js')}}"></script><!-- JQUERY.MIN JS -->
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="{{asset('vendor/bootstrap-select/js/bootstrap-select.min.js')}}"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="{{asset('vendor/rangeslider/rangeslider.js')}}"></script><!-- RANGESLIDER -->
    <script src="{{asset('vendor/magnific-popup/magnific-popup.js')}}"></script><!-- MAGNIFIC POPUP JS -->
    <script src="{{asset('vendor/lightgallery/js/lightgallery-all.min.js')}}"></script><!-- LIGHTGALLERY -->
    <script src="{{asset('vendor/Splitting/dist/Splitting.min.js')}}"></script><!-- Splitting -->
    <script src="{{asset('vendor/counter/waypoints-min.js')}}"></script><!-- WAYPOINTS JS -->
    <script src="{{asset('vendor/counter/counterup.min.js')}}"></script><!-- COUNTERUP JS -->
    <script src="{{asset('vendor/swiper/swiper-bundle.min.js')}}"></script><!-- OWL-CAROUSEL -->

    <script src="{{asset('js/ic.carousel.js')}}"></script><!-- OWL-CAROUSEL -->
    <script src="{{asset('js/ic.ajax.js')}}"></script><!-- AJAX -->
    <script src="{{asset('js/custom.min.js')}}"></script><!-- CUSTOM JS -->
</body>

</html>