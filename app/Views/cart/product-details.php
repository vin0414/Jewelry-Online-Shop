
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NASSER GOLDSMITH & JEWELRY STORE</title>
    <link rel="shortcut icon" href="<?=base_url('assets/Diamond Ring.ico')?>" type="image/x-icon">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">

    <link rel="stylesheet" href="<?=base_url('assets/style.css')?>">
</head>

<body>
    <div class="home_black_version">
        <header class="header_area header_black">
            <!-- header top starts -->
            <div class="header_top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="social_icone">
                                <ul>
                                    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                    <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="top_right text-right">
                                <ul>
                                    <li class="top_links">
                                        <?php if(empty(session()->get('sess_id'))){ ?>
                                            <a href="<?=site_url('sign-in')?>">Sign-In</a>
                                        <?php }else{ ?>
                                            <a href="#">My Account <i class="ion-chevron-down"></i></a>
                                            <ul class="dropdown_links">
                                                <li><a href="<?=site_url('customer/orders')?>">My Orders</a></li>
                                                <li><a href="<?=site_url('customer/account')?>">My Account</a></li>
                                                <li><a href="<?=site_url('customer/wish-list')?>">Wishlist</a></li>
                                                <li><a href="<?=site_url('sign-out')?>">Sign-out</a></li>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header top ends -->

            <!-- header middle starts -->
            <div class="header_middel">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-5">
                            <div class="home_contact">
                                <div class="contact_icone">
                                    
                                </div>
                                <div class="contact_box">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3 col-4">
                            <div class="logo">
                                <a href="/"><img src="<?=base_url('assets/images/logo/LOGO2-Photoroom.jpg')?>" alt=""></a>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-7 col-6">
                            <div class="middel_right">
                                <div class="search_btn">
                                    <a href="#"><i class="ion-ios-search-strong"></i></a>
                                    <div class="dropdown_search">
                                        <form action="#">
                                            <input type="text" placeholder="Search Product ....">
                                            <button type="submit"><i class="ion-ios-search-strong"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="cart_link">
                                    <a href="#"><i class="ion-android-cart"></i><span class="cart_text_quantity">PhP 0.00</span><i class="ion-chevron-down"></i></a>
                                    <span class="cart_quantity">0</span>

                                    <!-- mini cart -->
                                    <div class="mini_cart">
                                        <div class="cart_close">
                                            <div class="cart_text">
                                                <h3>cart</h3>
                                            </div>
                                            <div class="mini_cart_close">
                                                <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                                            </div>
                                        </div>
                                        <div class="cart_item">
                                            <div class="cart_img">
                                                <a href="#"><img src="assets/images/nav-product/product.jpg" alt=""></a>
                                            </div>
                                            <div class="cart_info">
                                                <a href="#">Earings</a>
                                                <span class="quantity">Qty : 1</span>
                                                <span class="price_cart">Rs. 54,599</span>
                                            </div>
                                            <div class="cart_remove">
                                                <a href="#"><i class="ion-android-close"></i></a>
                                            </div>
                                        </div>
                                        <div class="cart_total">
                                            <span>Subtotal : </span>
                                            <span>Rs. 67,598</span>
                                        </div>
                                        <div class="mini_cart_footer">
                                            <div class="cart_button checkout">
                                                <a href="<?=site_url('customer/orders')?>" class="active">View Orders</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- mini cart ends  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- header middle ends -->

            <!-- header bottom starts -->

            <div class="header_bottom sticky-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="main_menu_inner">
                                <div class="logo_sticky">
                                    <a href="/"><img src="assets/images/logo/LOGO2-Photoroom.jpg" alt=""></a>
                                </div>
                                <div class="main_menu">
                                    <nav>
                                        <ul>
                                            <li>
                                                <a href="/">Home</a>
                                            </li>
                                            <li class="active">
                                                <a href="javascript:void(0);">Product Details</a>
                                            </li>
                                            <li>
                                                <a href="#">Category <i class="ion-chevron-down"></i></a>
                                                <ul class="mega_menu">
                                                    <li>
                                                        <a href="#">Women</a>
                                                        <ul>
                                                            <li><a href="#">Earring</a></li>
                                                            <li><a href="#">Pendant</a></li>
                                                            <li><a href="#">Rings</a></li>
                                                            <li><a href="#">Chain</a></li>
                                                            <li><a href="#">Bangles</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="#">Men</a>
                                                        <ul>
                                                            <li><a href="#">Ring</a></li>
                                                            <li><a href="#">Pendant</a></li>
                                                            <li><a href="#">Bracelet</a></li>
                                                            <li><a href="#">Chain</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="<?=site_url('AboutUs')?>">About Us</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header bottom ends -->
        </header>

        <section class="product_section p_section1 product_black_section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product_area">
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- product section area sends -->
        <!-- footer section starts -->
        <footer class="footer_widgets footer_black">
            <div class="container">
                <div class="footer_top">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-8">
                            <div class="widgets_container contact_us">
                                <h3>About Nasser Goldsmith & Jewelry </h3>
                                <div class="footer_contact">
                                    <p>Address : 148 Granja St. Brgy. 7, Lucena City, Quezon Province</p>
                                    <p>Phone : <a href="tel:(+63)888888885555">(+63)888888885555</a></p>
                                    <p>Email : robinnasser@gmail.com</p>
                                    <ul>
                                        <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                        <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                                        <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-4 col-6">
                            <div class="widgets_container widget_menu">
                                <h3>Information</h3>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="AboutUs">About Us</a></li>
                                        <li><a href="ContactUs">Contact</a></li>
                                        <li><a href="FAQ">FAQs</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-5 col-6">
                            <div class="widgets_container widget_menu">
                                <h3>My Account</h3>
                                <div class="footer_menu">
                                    <ul>
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="#">Orders</a></li>
                                        <li><a href="#">Wishlist</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-7">
                            <div class="image-container">
                                <img src="<?=base_url('assets/images/logo/Logo-Photoroom.png-Photoroom.png')?>" alt="">
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="footer_bottom">
                    <div class="row">
                        <div class="col-12">
                            <div class="copyright_area">
                                <p>Copyright &copy; <?php echo date('Y') ?> <a href="#">NASSER GOLDSMITH & JEWELRY</a> All rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </footer>
        <!-- footer section ends -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- JavaScript Bundle with Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="<?=base_url('assets/main.js')?>"></script>
</body>

</html>