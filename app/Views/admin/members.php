
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?=base_url('assets/Diamond Ring.ico')?>" type="image/x-icon">
    <title>Nasser Jewelry - Members</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap"
      rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

      .nav__side__icon {
        transition: all 0.3s ease;
      }

      .nav__links {
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        border-radius: 1rem;
      }
      .hidden .nav__links {
        justify-content: center;
      }
      .nav__links:hover {
        background-color: #262626;
        color: #fff;

        cursor: pointer;
      }
      .nav__links.active {
        background-color: #262626;
        color: #fff;

        cursor: pointer;
      }
      .active .nav__list {
        color: #fff;
      }
      .active .nav__side__icon {
        color: #fff;
      }

      .nav__links:hover .nav__list {
        color: #fff;
      }
      .nav__links:hover .nav__side__icon {
        color: #fff;
      }

      .nav__list.hidden {
        display: none;
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
        display: flex;
        gap: 1rem;
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
      }
      .nav__links {
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

      /*  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *ADMIN PANEL CSS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
      /*  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *ADMIN PANEL CSS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
      /*  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *ADMIN PANEL CSS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
      /*  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *ADMIN PANEL CSS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
      /*  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *ADMIN PANEL CSS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
      /*  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *ADMIN PANEL CSS * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

      .tab__search {
        display: flex;
        justify-content: space-between;
      }

      .navigation__tabs {
        display: flex;
        gap: 0.3rem;
        background-color: #d4d4d4;
        padding: 0.4rem;
        border-radius: 0.8rem;
        align-items: center;
      }

      .navigation__item {
        padding: 0.5rem 1rem;
        background-color: #d4d4d4;
        border-radius: 0.4rem;
        cursor: pointer;
      }
      .navigation__item.active {
        background-color: #fff;
      }
      .input__search {
        border: 1px solid gray;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        height: 4rem;
        width: 30rem;
        font-size: 1.6rem;
      }

      .first__row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 3.2rem;
        margin-top: 3.2rem;
      }
      .second__row {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        margin-top: 3.2rem;
        gap: 3.2rem;
      }
      .third__row {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        margin-top: 3.2rem;
        gap: 3.2rem;
      }

      .charts,
      .table__container {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        border-radius: 1rem;
      }

      .card {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        padding: 2.4rem;
        border-radius: 1rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
      }

      .card__heading__number {
        font-size: 3rem;
        text-align: center;
      }
      .card__textdescription {
        font-size: 1.2rem;
        color: #7e7e7e;
        text-align: center;
      }
      .image__table {
        width: 8rem;
        border-radius: 50%;
        margin: 0 auto;
        display: flex;
      }

      .table {
        width: 100%;
      }

      th,
      td {
        padding: 2rem 0.5rem;
      }

      .charts {
        width: 100%;
        height: 100%;
      }

      /* QUERY */

      /* 1440 px */
      @media (max-width: 90em) {
        html {
          font-size: 55%;
        }
        .order__details__box {
          flex-wrap: wrap;
          gap: 3rem;
        }
      }
      /* 1230 px */
      @media (max-width: 76.875em) {
        html {
          font-size: 50%;
        }
        .table__image {
          width: 10rem;
          height: 10rem;
        }
      }
      @media (max-width: 62.5em) {
        .first__row {
          grid-template-columns: 1fr 1fr;
        }
      }
      /* 870px */

      @media (max-width: 54.375em) {
        table {
          font-size: 1.4rem;
        }
        body {
          font-size: 1.6rem;
        }
        .order__item__subtitle {
          font-size: 1rem;
        }
        .table__image {
          width: 6rem;
          height: 6rem;
        }

        .second__row,
        .third__row {
          grid-template-columns: 1fr 1fr;
        }
        .image__table {
          width: 5rem;
        }
        th,
        td {
          padding: 1rem 0.5rem;
        }

        .charts,
        .table__container {
          padding: 1rem;
        }

        .order__box {
          padding: 5rem 2rem;
        }
      }
      /* 600px */
      @media (max-width: 37.5em) {
        html {
          font-size: 50%;
        }
        .table {
          width: 100%;
        }
      }
      /* 530px */
      @media (max-width: 33.125em) {
        .first__row,
        .second__row,
        .third__row {
          grid-template-columns: 1fr;
        }
      }
      .row{
          display: flex;
          grid-template-columns: 1fr 1fr;
          grid-column-gap:20px;
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
      .form-control{padding:10px 18px;width:100%;}
      .bg-default,.btn-default{background-color:#262626;color:#fff;}
      .bg-success,.btn-success{background-color:limegreen;color:#fff;}
      .bg-danger,.btn-danger{background-color:crimson;color:#fff;}
      .btn {
        border: none;border-radius: 10px 10px;
        padding: 15px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        margin: 2px 2px;
        cursor: pointer;
      }
      .btn-sm{padding:12px 18px;}
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
            <a href="<?=site_url('account-settings')?>" class="drop__down__menu__item">My Account</a>
            <a href="<?=site_url('log-out')?>" class="drop__down__menu__item">Logout</a>
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
        <ul class="nav__list__container">
          <a href="<?=site_url('dashboard')?>" class="nav__links margin_top_2">
            <ion-icon class="nav__side__icon" name="home-outline"></ion-icon>
            <li class="nav__list">Dashboard</li></a
          >
          <a href="<?=site_url('products')?>" class="nav__links">
            <ion-icon class="nav__side__icon" name="diamond-outline"></ion-icon>
            <li class="nav__list">Products</li></a
          >
          <a href="<?=site_url('customer-orders')?>" class="nav__links">
            <ion-icon
              class="nav__side__icon"
              name="trending-up-outline"
            ></ion-icon>
            <li class="nav__list">Orders</li></a
          >
          <a href="<?=site_url('sales-report')?>" class="nav__links">
            <ion-icon
              class="nav__side__icon"
              name="file-tray-full-outline"
            ></ion-icon>
            <li class="nav__list">Reports</li></a
          >
        </ul>
        <p class="nav__list side__text margin_top_2">Tools</p>
        <ul class="nav__list__container">
          <a href="<?=site_url('settings')?>" class="nav__links margin_top_2">
            <ion-icon
              class="nav__side__icon"
              name="help-circle-outline"
            ></ion-icon>
            <li class="nav__list">Settings</li></a
          >
          <a href="<?=site_url('members')?>" class="nav__links active">
            <ion-icon class="nav__side__icon" name="person-outline"></ion-icon>
            <li class="nav__list">Users</li></a
          >
          <a href="<?=site_url('log-out')?>" class="nav__links">
            <ion-icon class="nav__side__icon" name="log-in-outline"></ion-icon>
            <li class="nav__list">Logout</li></a
          >
        </ul>
      </aside>

      <div class="container">
        <div class="content">
          <div class="row">
            <div class="col-6">
            <input type="search" class="form-control" id="search" placeholder="Search"/>
            </div>
            <div class="col-2">
              <a href="<?=site_url('new')?>" class="btn btn-default form-control btn-sm">Add Product</a>
            </div>
          </div>
          <div class="first__row" id="productResult">
          
          </div>
        </div>
      </div>
      <footer></footer>
    </main>
    <script>
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
        const links = document.querySelectorAll(".nav__list");
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
        const links = document.querySelectorAll(".nav__list");
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
    <script>
      
    </script>
  </body>
</html>
