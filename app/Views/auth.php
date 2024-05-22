
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-In - Administrator Portal</title>
    <link rel="shortcut icon" href="assets/Diamond Ring.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/style2.css">
    <style>
        .row,.col-12{margin:10px;}
        .form-control{width:100%;padding:10px;margin:5px;}
        .btn,.btn-primary{padding:10px;color:#ffffff;font-family:Arial, Helvetica, sans-serif;
            background-color:blue;border:1px solid blue;border-radius: 3px 3px;}
        .btn:hover{color:blue;background-color:#ffffff;font-weight:bold;}
        .check-box{width:18px;height:18px;}
        .alert-danger{background-color:red;padding:20px;color:#ffffff;}
    </style>
</head>
<body>
    <div class="about-section" style="margin-top:-75px;">
        <div class="inner-container">
        <a href="/" style="float:right;">Home</a>
            <h1>Administrator Portal</h1>
            <?php if(!empty(session()->getFlashdata('fail'))) : ?>
                <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('fail'); ?>
                </div>
            <?php endif; ?>
            <form method="post" class="row" id="frmLogin" action="<?=base_url('validate')?>">
                <div class="col-12 form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" required/>
                </div>
                <div class="col-12 form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" id="password" required/>
                </div>
                <div class="col-12 form-group">
                    <input type="checkbox" class="check-box" onclick="myFunction()"> Show Password
                </div>
                <div class="col-12 form-group">
                    <button type="submit" class="btn btn-primary" id="btnLogin">Sign-In</button>
                </div>
                <div class="col-12">
                    <label>Forgot Password? Click <a href="/forgot-password">here</a></label>
                </div>
            </form>
        </div>
    </div>
    <script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
  </script>
</body>
</html>