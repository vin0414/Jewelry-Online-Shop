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