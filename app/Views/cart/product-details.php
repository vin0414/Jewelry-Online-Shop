
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
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
                                            <a href="#"><?php echo session()->get('sess_fullname') ?> <i class="ion-chevron-down"></i></a>
                                            <ul class="dropdown_links">
                                                <li><a href="<?=site_url('orders')?>">My Orders</a></li>
                                                <li><a href="<?=site_url('history')?>">Order History</a></li>
                                                <li><a href="<?=site_url('account')?>">My Account</a></li>
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
                                            <li><a href="<?=site_url('shop')?>">Shop Now</a></li>
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
                <br/>
                <div class="row">
                    <div class="col-12">
                        <div class="product_area">
                            <div class="container">
                                <div class="row">
                                    <?php foreach($product as $row): ?>
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <div class="modal_tab">
                                            <div class="tab-content product-details-large">
                                                <div class="tab-pane fade show active" id="tab0" role="tabpanel">
                                                    <div class="modal_tab_img">
                                                        <a href="#"><img src="<?=base_url('assets/images/product')?>/<?php echo $row->Image ?>" alt=""></a>
                                                    </div>
                                                </div>
                                                <?php foreach($photos as $item): ?>
                                                <div class="tab-pane fade" id="tab<?php echo $item['mpID']?>" role="tabpanel">
                                                    <div class="modal_tab_img">
                                                        <a href="#"><img src="<?=base_url('assets/images/product')?>/<?php echo $item['Image'] ?>" alt=""></a>
                                                    </div>
                                                </div>
                                                <?php endforeach;?>
                                            </div>
                                            <div class="modal_tab_button">
                                                <ul class="nav product_navactive owl-carousel" role="tablist">
                                                    <?php foreach($photos as $item): ?>
                                                    <li>
                                                        <a href="#tab<?php echo $item['mpID']?>" class="nav-link" data-toggle="tab" role="tab"
                                                            aria-controls="tab2" aria-selected="false">
                                                            <img src="<?=base_url('assets/images/product')?>/<?php echo $item['Image'] ?>" style="height:130px;width:150px;"/>
                                                        </a>
                                                    </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-12">
                                        <div class="modal_right">
                                            <div class="modal_title mb-10">
                                                <h2 style="color:#fff;"><?php echo $row->productName ?></h2>
                                            </div>
                                            <?php if($row->onSales=="Yes"){ ?>
                                            <div class="modal_price mb-10">
                                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice-($row->UnitPrice*$row->Discount),2) ?></span>
                                                <span class="old_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                                            </div>
                                            <?php }else {?>
                                            <div class="modal_price mb-10">
                                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                                            </div>
                                            <?php } ?>
                                            <p>Category : <?php echo $row->CategoryName ?></p>
                                            <p>Product Type : <?php echo $row->Product_Type ?></p>
                                            <?php if($row->Qty==0){ ?>
                                              <span class="badge bg-danger text-white" style="padding:10px;">Out of Stock</span>
                                            <?php }else{ ?>
                                            <div class="modal_add_to_cart mb-15">
                                                <form method="post" action="<?=base_url('buy/'.$row->productID)?>">
                                                    <input type="number" min="0" name="qty" id="qty" max="100" style="color:#fff;" required/>
                                                    <button type="submit" class="btn">Add To Cart</button>
                                                </form>
                                            </div>
                                            <?php } ?>
                                            <div class="modal_description mb-15">
                                                <p><?php echo $row->Description ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div> 
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