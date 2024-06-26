<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?=base_url('assets/Diamond Ring.ico')?>" type="image/x-icon">
    <title>Order History</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap"
      rel="stylesheet"
    />
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
      .active{background-color: #262626;color:#fff;}
      .badge {
        padding: 4px 8px;
        text-align: center;
        border-radius: 5px;
      }
      .bg-default,.btn-default{background-color:#262626;color:#fff;}
      .bg-success{background-color:limegreen;color:#fff;}
      .bg-danger{background-color:crimson;color:#fff;}
      .btn {
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        margin: 2px 2px;
        cursor: pointer;
      }
      .form-control{padding:10px 18px;}
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

          <li class="nav__list active">
            <ion-icon
              class="nav__side__icon"
              name="bag-handle-outline"
            ></ion-icon>
            <a href="<?=site_url('history')?>" class="nav__links" style="color:#fff;">Order History</a>
          </li>
        </ul>
        <p class="nav__links side__text margin_top_2">Tools</p>
        <ul class="nav__list__container">
          <li class="nav__list margin_top_2">
            <ion-icon class="nav__side__icon" name="person-outline"></ion-icon>
            <a href="<?=site_url('account')?>" class="nav__links">My Account</a>
          </li>
          <li class="nav__list">
            <ion-icon name="log-in-outline"></ion-icon>
            <a href="<?=site_url('sign-out')?>" class="nav__links">Sign out</a>
          </li>
        </ul>
      </aside>

      <div class="container">
        <input type="search" id="search" class="form-control" name="search" placeholder="Search" style="float:right;"/>
        <div class="order__heading__box">
          <ion-icon class="order__icon" name="reader-outline"></ion-icon>
          <p class="order__heading">Order History</p>         
        </div>
        <div>
        <?php if(empty($orders)){ ?>
          <div class="order__box margin_top_4">
            <div class="order__details__box">
              <p>No Available Order(s)</p>
            </div>  
          </div>
        <?php }else{?>   
          <div class="order__box margin_top_4" id="results">
            <?php foreach($orders as $row): ?>
              <div class="order__details__box">
                <div class="order__text__boxx">
                  <p class="order__text__heading">Delivery Address</p>
                  <p class="order__text__description margin_top_2">
                    <span><?php echo $row['DeliveryAddress'] ?></span>
                  </p>
                  <p class="order__text__date">
                    <span class="badge bg-default"><?php echo $row['Remarks'] ?></span>
                  </p>
                </div>
                <div class="order__text__boxx">
                  <p class="order__text__heading">Order Details</p>
                  <p class="order__text__description margin_top_2">
                    Reference No : <span><?php echo $row['TransactionNo'] ?></span>
                  </p>
                  <p class="order__text__date">Payment Status: 
                    <?php if($row['Status']==1){ ?>
                      <span class="badge bg-default">Confirmed</span>
                    <?php }else if($row['Status']==2){?>
                      <span class="badge bg-danger">Cancelled</span>
                    <?php }else{ ?>
                      <span class="badge bg-success">Paid</span>
                    <?php } ?>
                  </p>
                </div>
                <div class="order__text__boxx">
                  <p class="order__text__heading">Total Amount</p>
                  <p class="order__text__description margin_top_2">PhP <?php echo number_format($row['Total'],2)?></p>
                </div>
                <div class="order__text__box">
                  <p class="order__text__heading">&nbsp;</p>
                  <br/>
                  <a href="<?=site_url('view-order/')?><?php echo $row['TransactionNo'] ?>" class="btn btn-default">View</a>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
        <?php } ?>
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
              parentBox.classList.toggle("hide");
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
  $('#search').keyup(function(){
    var val = $(this).val();
    $('#results').html("<div class='order__details__box'><p>Searching...</p></div>");
    $.ajax({
      url:"<?=site_url('search-customer-orders')?>",method:"GET",
      data:{keyword:val},
      success:function(response)
      {
        if(response==="")
        {
          $('#results').html("<div class='order__details__box'><p>No Record(s)</p></div>");
        }
        else
        {
          $('#results').html(response);
        }
      }
    });
  });
</script>
</body>
</html>
