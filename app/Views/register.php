
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="shortcut icon" href="assets/Diamond Ring.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/style2.css">
    <style>
        .row,.col-12{margin:10px;}
        .form-control{width:100%;padding:10px;margin:5px;}
        .btn,.btn-primary{padding:10px;color:#ffffff;font-family:Arial, Helvetica, sans-serif;
            background-color:blue;border:1px solid blue;border-radius: 3px 3px;}
        .btn:hover{color:blue;background-color:#ffffff;font-weight:bold;}
        .check-box{width:18px;height:18px;}
    </style>
</head>
<body>
    <div class="about-section" style="margin-top:-130px;">
        <div class="inner-container">
            <h1>Register Here</h1>
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
            <form method="post" class="row" id="frmRegister" action="<?=base_url('create-account')?>">
                <?= csrf_field(); ?>
                <div class="col-12 form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" required/>
                </div>
                <div class="col-12 form-group">
                    <label>Complete Name</label>
                    <input type="text" class="form-control" name="fullname" required/>
                </div>
                <div class="col-12 form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
                </div>
                <div class="col-12 form-group">
                    <label>ReType Password</label>
                    <input type="password" class="form-control" name="retype_password" id="retype_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
                </div>
                <div class="col-12 form-group">
                    <input type="checkbox" onclick="myFunction()"> Show Password
                </div>
                <div class="col-12 form-group">
                    <button type="submit" class="btn btn-danger" id="btnLogin">Register</button>
                </div>
                <div class="col-12">
                    <label>Already have an account? Click <a href="/sign-in">here</a></label>
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