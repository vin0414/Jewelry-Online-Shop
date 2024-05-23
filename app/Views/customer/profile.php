<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?=base_url('assets/Diamond Ring.ico')?>" type="image/x-icon">
    <title>My Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?=base_url('assets/css/styles.css')?>" />
    <link rel="stylesheet" href="<?=base_url('assets/css/queries.css')?>" />
    <style>
      :root {
        --main-color: #262626;
      }

      * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
      }

      html {
        font-size: 62.5%;
      }

      body {
        font-family: "Inter", sans-serif;
        font-size: 1.8rem;
        line-height: 1;
        font-weight: 400;
      }
      main {
        display: grid;
        grid-template-columns: 0.25fr 1.75fr;
        overflow: auto;
      }
      .navigation {
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 0.3rem 2rem;
        border-bottom: 1px solid #e0e0e0;
      }

      .container {
        width: 90%;
        margin: 0 auto;
        padding: 5rem 2rem;
      }

      .logo__image {
        width: 100%;
        height: 5.2rem;
        object-fit: cover;
      }

      .nav__account__box {
        display: flex;
        align-items: center;
        gap: 2rem;
        position: relative;
      }

      .nav__account__image {
        aspect-ratio: 16 / 9;
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
      }

      .nav__account__name {
        font-weight: 500;
      }

      .nav__list__container {
        list-style: none;
      }
      .nav__list {
        transition: all 0.3s ease;
        border-radius: 1rem;
      }
      .nav__list:hover {
        background-color: #262626;
        color: #fff;
        cursor: pointer;
      }
      .nav__links {
        transition: all 0.3s ease;
        cursor: pointer;
      }
      .nav__list:hover .nav__links {
        color: #fff;
      }
      .side__button {
        font-family: "Inter", sans-serif;
        color: #fff;
        font-weight: 600;
        border: none;
        background-color: var(--main-color);
        padding: 1.5rem 2rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 1.8rem;
        align-self: center;
        cursor: pointer;
      }

      .side__bar {
        display: flex;
        flex-direction: column;
        padding: 0 1rem;
        box-shadow: 0 0 1px 0 rgba(160, 160, 160, 0.75);
        height: 100%;
      }

      .nav__links:link,
      .nav__links:visited {
        color: var(--main-color);
        text-decoration: none;
      }
      .nav__links:hover,
      .nav__links:active {
        color: #4e4e4e;
      }

      .nav__list {
        color: var(--main-color);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem 1rem;
      }

      .nav__list__container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
      }

      .margin_top_2 {
        margin-top: 2rem;
      }
      .margin_top_4 {
        margin-top: 4rem;
      }

      /* ORDERS */

      .order__heading__box {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
      }
      .order__icon {
        width: 2rem;
        height: 2rem;
      }

      .order__box {
        background-color: #fff;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2), 0 2px 7px rgba(0, 0, 0, 0.19);
        padding: 5rem 4rem;
        display: flex;
        flex-direction: column;
        gap: 4rem;
        border-radius: 1rem;
      }

      .order__details__box {
        display: flex;

        justify-content: space-between;
        border-bottom: 1px solid #dedede;
        padding-bottom: 2rem;
      }

      .order__text__heading {
        font-size: 2rem;
        font-weight: 600;
      }
      .table__image {
        width: 15rem;
        height: 15rem;
        /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
        border-radius: 1rem;
      }

      .width-7 {
        width: 7rem;
      }

      .order__item__title {
        font-weight: 600;
      }
      .order__item__subtitle {
        font-weight: 400;
        font-size: 1.6rem;
        color: gray;
        padding-top: 0.4rem;
      }

      .order__drop__down {
        width: 2.2rem;
        height: 2.2rem;
        cursor: pointer;
        padding: 0.5rem;
      }

      .sidebar__menu {
        width: 3.2rem;
        height: 3.2rem;
      }
      table {
        table-layout: auto;
        border-collapse: collapse;
        /* width: 300px; */
        table-layout: fixed;
      }
      td,
      th {
        padding: 0;
        margin: 0;
        word-wrap: break-word;
        text-align: left;
        max-width: 15rem;
      }

      td {
        padding: 0 0.3rem;
      }

      /* .table.hide {
  visibility: hidden;
  opacity: 0;
  height: 0;
} */
      .order__box {
        transition: all 0.3s ease;
        overflow: auto;
      }
      .table.hide {
        display: none;
        overflow: hidden;
      }

      .sidebar__menu {
        cursor: pointer;
        padding: 1rem;
      }

      .nav__links.hidden {
        display: none;
      }

      .width-43 {
        width: 43%;
      }

      main.hidden .nav__list {
        justify-content: center;
      }

      main.hidden {
        grid-template-columns: 0.05fr 1.95fr;
      }
      .side__button__text.hidden {
        display: none;
      }

      .drop__down__menu {
        position: absolute;
        right: 0;
        padding: 1rem;
        background-color: #fff;
        width: 100%;
        height: 10rem;
        bottom: -10rem;
        border-radius: 1rem;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        gap: 2rem;
        align-items: center;
        padding: 2rem 1rem;

        visibility: visible;
        opacity: 1;
        transform: translateY(0%);

        transition: all 0.3s ease;
      }

      .nav__account__box {
        cursor: pointer;
      }
      .hidden .drop__down__menu {
        visibility: hidden;
        opacity: 0;
        transform: translateY(-20%);
      }
      .drop__down__menu__item:link,
      .drop__down__menu__item:visited {
        color: var(--main-color);
        text-decoration: none;
      }

      .order__text__description {
        line-height: 1.3;
      }
      .order__text__date {
        color: #494949;
        font-weight: 500;
        font-size: 1.5rem;
        margin-top: 0.5rem;
      }
      .col-1 {width: 8.33%;}
      .col-2 {width: 16.66%;}
      .col-3 {width: 25%;}
      .col-4 {width: 33.33%;}
      .col-5 {width: 41.66%;}
      .col-6 {width: 50%;}
      .col-7 {width: 58.33%;}
      .col-8 {width: 66.66%;}
      .col-9 {width: 75%;}
      .col-10 {width: 83.33%;}
      .col-11 {width: 91.66%;}
      .col-12 {width: 100%;}
      .active{background-color: #262626;color:#fff;}
      .row{
          display: flex;
          grid-template-columns: 1fr 1fr;
          grid-column-gap:20px;
      }
      .row-form{
          display: grid;
          grid-template-columns: auto;
          grid-gap: 10px;
          padding: 10px;
      }
      .form-group{padding-top:5px;padding-bottom: 5px;}
      .form-control{padding:10px 18px;width:100%;}
      .bg-default,.btn-default{background-color:#262626;color:#fff;}
      .bg-success,.btn-success{background-color:limegreen;color:#fff;}
      .bg-danger,.btn-danger{background-color:crimson;color:#fff;}
      .btn {
        border: none;border-radius: 10px 10px;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
        margin: 2px 2px;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <header class="header">
      <nav class="navigation">
        <div class="icon__box">
          <img
            src="<?=base_url('assets/images/logo/LOGO2-Photoroom.jpg')?>"
            class="logo__image"
            alt="Nasser Logo"
          />
        </div>
        <div id="accountModal" class="nav__account__box hidden">
          <p class="nav__account__name"><?php echo session()->get('sess_fullname') ?></p>
          <ion-icon
            class="nav__account__icon"
            name="chevron-down-outline"
          ></ion-icon>
          <div class="drop__down__menu">
            <a href="<?=site_url('account')?>" class="drop__down__menu__item">My Account</a>
            <a href="<?=site_url('sign-out')?>" class="drop__down__menu__item">Logout</a>
          </div>
        </div>
      </nav>
    </header>
    <main>
      <aside class="side__bar" id="sideBarContainer">
        <ion-icon
          id="sideBarMenu"
          class="sidebar__menu"
          name="menu-outline"
        ></ion-icon>
        <a href="<?=site_url('shop')?>" style="text-decoration:none;" class="side__button margin_top_2">
          <ion-icon class="side__icon white" name="cart-outline"></ion-icon
          ><span class="side__button__text">Shop</span>
        </a>
        <ul class="nav__list__container">
          <li class="nav__list margin_top_2">
            <ion-icon class="nav__side__icon" name="bag-handle-outline"></ion-icon>
            <a href="<?=site_url('orders')?>" class="nav__links">My Orders</a>
          </li>

          <li class="nav__list">
            <ion-icon
              class="nav__side__icon"
              name="bag-handle-outline"
            ></ion-icon>
            <a href="<?=site_url('history')?>" class="nav__links">Order History</a>
          </li>
        </ul>
        <p class="nav__links side__text margin_top_2">Tools</p>
        <ul class="nav__list__container">
          <li class="nav__list margin_top_2 active">
            <ion-icon class="nav__side__icon" name="person-outline"></ion-icon>
            <a href="<?=site_url('account')?>" class="nav__links" style="color:#fff;">My Account</a>
          </li>
          <li class="nav__list">
            <ion-icon name="log-in-outline"></ion-icon>
            <a href="<?=site_url('sign-out')?>" class="nav__links">Sign out</a>
          </li>
        </ul>
      </aside>

      <div class="container">
        <div class="order__heading__box">
          <ion-icon class="order__icon" name="person-outline"></ion-icon>
          <p class="order__heading">My Account</p>
        </div>
        <div class="row">
          <div class="col-8 form-group">
            <div class="order__box margin_top_4">
              <p>Account Information</p>
              <form method="POST" class="row-form" id="frmAccount">
                <?php if($customer): ?>
                <div class="col-12 form-group">
                  <label><b>Fullname</b></label>
                  <input type="text" class="form-control" value="<?=$customer['Fullname']?>" name="fullname" required/>
                </div>
                <div class="col-12 form-group">
                  <label><b>Email Address</b></label>
                  <input type="email" class="form-control" value="<?=$customer['Email']?>" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required/>
                </div>
                <?php endif;?>
                <div class="col-12 form-group">
                  Personal Details
                </div>
                <?php if($info): ?>
                <div class="col-12 form-group">
                  <div class="row">
                    <div class="col-4">
                      <label><b>Birth Date</b></label>
                      <input type="date" class="form-control" value="<?=$info['BirthDate']?>" name="birthdate" required/>
                    </div>
                    <div class="col-4">
                      <label><b>Contact No</b></label>
                      <input type="phone" id="phone" class="form-control" value="<?=$info['ContactNo']?>"  maxlength="11" minlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="phone" required/>
                    </div>
                    <div class="col-4">
                      <label><b>Gender</b></label>
                      <select class="form-control" name="gender" required>
                        <option value="">Choose</option>
                        <option <?php if($info['Gender']=="Male") echo 'selected="selected"'; ?>>Male</option>
                        <option <?php if($info['Gender']=="Female") echo 'selected="selected"'; ?>>Female</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-12 form-group">
                  <label>Shipping Address</label>
                </div>
                <div class="col-12 form-group">
                  <div class="row">
                    <div class="col-6">
                      <label><b>Street</b></label>
                      <input type="text" class="form-control" name="street" value="<?=$info['Street']?>"  required/>
                    </div>
                    <div class="col-6">
                      <label><b>Village/Barangay</b></label>
                      <input type="text" class="form-control" name="barangay" value="<?=$info['Barangay']?>" required/>
                    </div>
                  </div>
                </div>
                <div class="col-12 form-group">
                  <div class="row">
                    <div class="col-6">
                      <label><b>City</b></label>
                      <input type="text" class="form-control" name="city" value="<?=$info['City']?>" required/>
                    </div>
                    <div class="col-4">
                      <label><b>Province</b></label>
                      <input type="text" class="form-control" name="province" value="<?=$info['Province']?>" required/>
                    </div>
                    <div class="col-2">
                      <label><b>Zip Code</b></label>
                      <input type="text" class="form-control" name="zipcode" value="<?=$info['ZipCode']?>" required/>
                    </div>
                  </div>
                </div>
                <?php endif;?>
                <div class="col-12 form-group">
                  <button type="submit" class="btn btn-default" id="btnSave">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-4 form-group">
            <div class="order__box margin_top_4">
              <p>Account Security</p>
              <form method="POST" class="row-form" id="frmPassword">
                <div class="col-12 form-group">
                  <label><b>Current Password</b></label>
                  <input type="password" class="form-control" name="current_password" id="current"/>
                </div>
                <div class="col-12 form-group">
                  <label><b>New Password</b></label>
                  <input type="password" class="form-control" name="new_password" id="new"/>
                </div>
                <div class="col-12 form-group">
                  <label><b>Confirm Password</b></label>
                  <input type="password" class="form-control" name="confirm_password" id="confirm"/>
                </div>
                <div class="col-12 form-group">
                    <input type="checkbox" onclick="myFunction()"> Show Password
                </div>
                <div class="col-12 form-group">
                  <button type="submit" class="btn btn-default" id="btnSubmit">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <footer></footer>
    </main>
    <script src="<?=base_url('assets/js/script.js')?>">
            document.addEventListener("DOMContentLoaded", function () {
        const dropdownIcons = document.querySelectorAll(".order__drop__down");

        function toggleTable() {
          const parentBox = this.closest(".order__box");
          if (parentBox) {
            const table = parentBox.querySelector(".table");

            if (table) {
              table.classList.toggle("hide");
            arentBox.classList.toggle("hide");
            }
          }
          const currentIconName = this.getAttribute("name");
          const newIconName =
            currentIconName === "chevron-up-outline"
              ? "chevron-down-outline"
              : "chevron-up-outline";
          this.setAttribute("name", newIconName);
        }

        dropdownIcons.forEach((icon) => {
          icon.addEventListener("click", toggleTable);
        });
      });

      document.addEventListener("DOMContentLoaded", function () {
        const sideBarMenu = document.getElementById("sideBarMenu");
        const sideBarContainer = document.getElementById("sideBarContainer");
        const links = document.querySelectorAll(".nav__links");
        const mainElement = document.querySelector("main");
        const sideButton = document.querySelector(".side__button");
        const sideButtonText = document.querySelector(".side__button__text");

        sideBarMenu.addEventListener("click", function () {
          sideBarContainer.classList.toggle("hidden");

          // Toggle visibility of nav__links
          links.forEach(function (link) {
            link.classList.toggle("hidden");
          });
          if (mainElement) {
            mainElement.classList.toggle("hidden");
          }
          if (sideButtonText) {
            sideButtonText.classList.toggle("hidden");
          }
        });

        let accountModal = document.getElementById("accountModal");
        accountModal.addEventListener("click", function () {
          accountModal.classList.toggle("hidden");
        });
      });

      function checkViewportWidth() {
        const main = document.querySelector("main");
        const sideBar = document.querySelector(".side__bar"); // Fixed selector
        const links = document.querySelectorAll(".nav__links");
        const sideButtonText = document.querySelector(".side__button__text");

        if (window.innerWidth >= 1000) {
          main.classList.remove("hidden");
          sideBar.classList.remove("hidden");
          sideButtonText.classList.remove("hidden");
          links.forEach(function (link) {
            link.classList.remove("hidden");
          });
        } else {
          main.classList.add("hidden");
          sideBar.classList.add("hidden");
          sideButtonText.classList.add("hidden");
          links.forEach(function (link) {
            link.classList.add("hidden");
          });
        }
      }

      // Run the function on initial load
      checkViewportWidth();

      // Add an event listener to run the function whenever the window is resized
      window.addEventListener("resize", checkViewportWidth);
    </script>
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
  <!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
<script>
  $('#btnSubmit').on('click',function(e){
    e.preventDefault();
    var data = $('#frmPassword').serialize();
    $.ajax({
      url:"<?=site_url('update-password')?>",method:"POST",
      data:data,success:function(response)
      {
        if(response==="success")
        {
          alert("Great! Successfully changed");
          $('#frmPassword')[0].reset();
        }
        else
        {
          alert(response);
        }
      }
    });
  });

  $('#btnSave').on('click',function(e){
    e.preventDefault();
    var data = $('#frmAccount').serialize();
    $.ajax({
      url:"<?=site_url('save-changes')?>",method:"POST",
      data:data,success:function(response)
      {
        if(response==="success")
        {
          alert("Great! Successfully applied changes");
          location.reload();
        }
        else
        {
          alert(response);
        }
      }
    });
  });
  function myFunction() {
    var x = document.getElementById("current");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }

    var xx = document.getElementById("new");
    if (xx.type === "password") {
        xx.type = "text";
    } else {
        xx.type = "password";
    }

    var xxx = document.getElementById("confirm");
    if (xxx.type === "password") {
        xxx.type = "text";
    } else {
        xxx.type = "password";
    }
  }
</script>
</body>
</html>
