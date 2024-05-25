
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>
    <link rel="shortcut icon" href="<?=base_url('assets/Diamond Ring.ico')?>" type="image/x-icon">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">

    <link rel="stylesheet" href="<?=base_url('assets/style.css')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                <a href="/"><img src="<?=base_url('assets/images/logo/LOGO2.jpg')?>" alt=""></a>
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
                                    <a href="/"><img src="assets/images/logo/LOGO2.jpg" alt=""></a>
                                </div>
                                <div class="main_menu">
                                    <nav>
                                        <ul>
                                            <li>
                                                <a href="/">Home</a>
                                            </li>
                                            <li class="active">
                                                <a href="javascript:void(0);">Check-out</a>
                                            </li>
                                            <li><a href="<?=site_url('orders')?>">My Orders</a></li>
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
                                <form method="POST" class="row" action="<?=base_url('confirmation')?>">
                                    <div class="col-lg-8 form-group">
                                        <table class="table table-bordered text-white">
                                            <thead>
                                                <th>&nbsp;</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                            </thead>
                                            <tbody>
                                                <?php if(empty($items)){ ?>
                                                    <tr><td colspan="6">No Order(s)</td></tr>
                                                <?php }else{ ?>
                                                <?php foreach($items as $row): ?>
                                                    <tr>
                                                        <td>
                                                            <center><a href="<?=site_url('remove-item/'.$row['id'])?>"><i class="text-danger fa fa-trash"></i></a></center>
                                                        </td>
                                                        <td>
                                                            <img src="<?=base_url('assets/images/product')?>/<?php echo $row['photo'] ?>" width="50"/>
                                                        </td>
                                                        <td><?php echo $row['name'] ?></td>
                                                        <td><?php echo $row['quantity'] ?></td>
                                                        <td><?php echo number_format($row['price'],2) ?></td>
                                                        <td><?php echo number_format($row['price']*$row['quantity'],2) ?></td>
                                                    </tr>
                                                <?php endforeach;?>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="5">Total</td>
                                                    <td><?=number_format($total,2)?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        <div class="row g-2">
                                            <div class="col-12 form-group">
                                                <input type="checkbox" style="height:15px;width:15px;" name="currentAddress" id="currentAddress"/>&nbsp;<label>Primary Address?</label>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label>Delivery Address</label>
                                                <textarea class="form-control" id="address" name="address" style="background-color:#000;color:#fff;" required></textarea>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label>Contact No</label>
                                                <input type="phone" id="phone" class="form-control" maxlength="11" minlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="contactNo" style="background-color:#000;color:#fff;" required/>
                                            </div>
                                            <div class="col-12 form-group">
                                                <p>Payment Details</p>
                                                <select class="form-control" name="payment" style="background-color: #000;color:#fff;" required>
                                                    <option value="">Choose</option>
                                                    <option value="COD">Cash On Delivery</option>
                                                    <option value="PICKUP">Pick-Up Delivery</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="amount" value="<?=$total?>"/>
                                            <div class="col-12 form-group">
                                                <br/>
                                                <?php if(empty($items)){ ?>
                                                    <button type="submit" class="btn btn-warning" disabled><span class="fa fa-check-circle"></span> Confirm Order(s)</button>
                                                <?php }else{?>
                                                    <button type="submit" class="btn btn-warning"><span class="fa fa-check-circle"></span> Confirm Order(s)</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <script>
        $('#currentAddress').change(function() {
            if(this.checked) {
                $.ajax({
                    url:"<?=site_url('fetch-primary-address')?>",method:"GET",
                    dataType:"JSON",
                    success:function(data)
                    {
                        $('#address').val(data["Address"]);
						$('#phone').val(data["contactNo"]);
                    }
                });
            }  
            else
            {
                $('#address').val("");
				$('#phone').val("");
            }     
        });
    </script>
</body>

</html>