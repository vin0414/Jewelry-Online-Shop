
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        .alert-success{background-color:green;padding:20px;color:#ffffff;}
    </style>
</head>
<body>
    <div class="about-section" style="margin-top:-75px;">
        <div class="inner-container">
        <a href="/" style="float:right;">Home</a>
            <?php if(!empty(session()->getFlashdata('fail'))) : ?>
                <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('fail'); ?>
                </div>
            <?php endif; ?>
            <?php if(!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>
            <h1>Forgot Password</h1>
            <form method="post" class="row" id="frmLogin" action="<?=base_url('request-password')?>">
                <div class="col-12 form-group">
                Enter the email address associated with your account to reset your password.
                </div>
                <div class="col-12 form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" required/>
                </div>
                <div class="col-12 form-group">
                    <button type="submit" class="btn btn-primary" id="btnLogin">Submit</button>
                </div>
                <div class="col-12">
                    <label>Already have an account? Sign In <a href="/auth">here</a></label>
                </div>
            </form>
        </div>
    </div>
</body>
</html>