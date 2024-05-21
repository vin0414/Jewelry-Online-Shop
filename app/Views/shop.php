
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Now</title>
    <link rel="shortcut icon" href="assets/Diamond Ring.ico" type="image/x-icon">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">

    <link rel="stylesheet" href="assets/style.css">
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
                                <a href="/"><img src="assets/images/logo/LOGO2-Photoroom.jpg" alt=""></a>
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
                                    <a href="javascript:void(0);"><i class="ion-android-cart"></i><span class="cart_text_quantity">PhP <?php echo number_format($total,2) ?></span><i class="ion-chevron-down"></i></a>
                                    <span class="cart_quantity"><?php echo number_format($volume,0) ?></span>

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
                                        <?php if(empty($items)){ ?>
                                            <div class="cart_info">
                                                No Item(s)
                                            </div>
                                        <?php }else{?>
                                        <?php foreach($items as $item): ?>
                                            <?php $imgURL = "assets/images/product/".$item['photo']; ?>
                                        <div class="cart_item">
                                            <div class="cart_img">
                                                <a href="#"><img src="<?php echo $imgURL ?>" alt=""></a>
                                            </div>
                                            <div class="cart_info">
                                                <a href="#"><?=$item['name']?></a>
                                                <span class="quantity">Qty : <?=$item['quantity']?></span>
                                                <span class="price_cart">PhP <?=number_format($item['quantity']*$item['price'],2)?></span>
                                            </div>
                                            <div class="cart_remove">
                                                <a href="<?=site_url('remove/'.$item['id'])?>"><i class="ion-android-close"></i></a>
                                            </div>
                                        </div>
                                        <?php endforeach;?>
                                        <div class="cart_total">
                                            <span>Subtotal : </span>
                                            <span>PhP <?php echo number_format($total,2) ?></span>
                                        </div>
                                        <div class="mini_cart_footer">
                                            <div class="cart_button checkout">
                                                <a href="<?=site_url('check-out')?>" class="active">Check Out</a>
                                            </div>
                                        </div>
                                        <?php } ?>
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
                                                <a href="/">Shop Now</a>
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

        <!-- slider section starts -->
        <div class="slider_area slider_black owl-carousel">
            <div class="single_slider" data-bgimg="assets/images/slider/1.png">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="slider_content">
                                <p>exclusive offer -20% off this week</p>
                                <h1>Necklace</h1>
                                <span>22 Carat gold necklace for wedding</span>
                                <p class="slider_price">starting at <span>Rs. 75,999</span></p>
                                <a href="<?=site_url('shop')?>" class="button">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="single_slider" data-bgimg="assets/images/slider/2.jpg">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="slider_content">
                                <p>exclusive offer -40% off this week</p>
                                <h1>Earings and Pendant</h1>
                                <span>Complete bridal set with white pearls</span>
                                <p class="slider_price">starting at <span>Rs. 89,499</span></p>
                                <a href="<?=site_url('shop')?>" class="button">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="single_slider" data-bgimg="assets/images/slider/3.jpg">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="slider_content">
                                <p>exclusive offer -10% off this week</p>
                                <h1>Wedding Rings</h1>
                                <span>Nasser Special wedding rings for couples.</span>
                                <p class="slider_price">starting at <span>Rs. 14,999</span></p>
                                <a href="<?=site_url('shop')?>" class="button">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- slider section ends -->
        <!-- banner section starts -->
        <!-- banner section ends -->
        <!-- product section area starts  -->

        <section class="product_section p_section1 product_black_section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <input type="search" class="form-control" style="background-color: #000;color:#fff;" id="search" name="search" placeholder="Search"/>
                    </div>
                    <div class="col-12">
                        <br/>
                        <div class="row g-3" id="loadProducts">
                            <?php foreach($products as $row): ?>
                                <div class="col-lg-3 form-group">
                                    <div class="card" style="background-color:#000;color:#fff;border:1px solid #fff;">
                                        <div class="card-body">
                                            <img src="assets/images/product/<?php echo $row->Image ?>"/>
                                            <center><?php echo $row->CategoryName ?></center>
                                            <center><h4><?php echo $row->productName ?></h4></center>
                                            <?php if($row->onSales=="Yes"){ ?>
                                            <div class="modal_price mb-10 text-center">
                                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice-($row->UnitPrice*$row->Discount),2) ?></span>
                                                <span class="old_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                                            </div>
                                            <?php }else {?>
                                            <div class="modal_price mb-10 text-center">
                                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                                            </div>
                                            <?php } ?>
                                            <div class="product_desc">
                                                <p class="text-center"><?php echo $row->Description ?></p>
                                            </div>
                                            <div class="action_links">
                                                <center>
                                                <ul>
                                                    <li><a href="#" data-placement="top" title="Add to Wishlist"
                                                            data-toggle="tooltip"><span
                                                                class="ion-heart"></span></a></li>
                                                    <li class="add_to_cart">
                                                        <a href="<?=site_url('cart/details/')?><?php echo $row->productID ?>" title="Add to Cart">Add to Cart</a>
                                                    </li>
                                                    <li><a href="#" title="Compare"><i
                                                                class="ion-ios-settings-strong"></i></a>
                                                    </li>
                                                </ul>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                                <img src="assets/images/logo/Logo-Photoroom.png-Photoroom.png" alt="">
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

    <script src="assets/main.js"></script>
    <script>
        $('#search').keyup(function(){
            var val = $(this).val();
            $('#loadProducts').html("<div><center>Loading...</center></div>");
            $.ajax({
                url:"<?=site_url('search-products')?>",method:"GET",
                data:{keyword:val},
                success:function(response)
                {
                    if(response==="")
                    {
                        $('#loadProducts').html("<div><center>Loading...</center></div>");
                    }
                    else
                    {
                        $('#loadProducts').html(response);
                    }
                }
            });
        });
    </script>
</body>

</html>