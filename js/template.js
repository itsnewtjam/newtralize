function toggleMenu() {
  let button = document.getElementById("nav-button");
  let menu = document.getElementById("primary-navigation");
  let overlay = document.querySelector("#nav-button + .menu-overlay");
  let isOpen = button.getAttribute("aria-expanded") == "true";
  let navTime = newtralizeData['nav_time'] ?? 0;
  if (isOpen) {
    window.removeEventListener("keydown", handleMenuKeyDown);
    button.setAttribute("aria-expanded", "false");
    menu.dataset.state = "closing";
    overlay.dataset.state = "closing";
    document.documentElement.style.overflow = "";
    document.body.style.position = "";
    document.body.style.inset = "";
    document.body.style.pointerEvents = "";
    setTimeout(() => {
      menu.dataset.state = "closed";
      overlay.dataset.state = "closed";
    }, navTime);
  } else {
    window.addEventListener("keydown", handleMenuKeyDown);
    let focusable = menu.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    focusable[0].focus();
    button.setAttribute("aria-expanded", "true");
    menu.dataset.state = "opening";
    overlay.dataset.state = "opening";
    document.documentElement.style.overflow = "hidden";
    document.body.style.position = "fixed";
    document.body.style.inset = "0";
    document.body.style.pointerEvents = "none";
    setTimeout(() => {
      menu.dataset.state = "open";
      overlay.dataset.state = "open";
    }, navTime);
  }
}

function handleMenuKeyDown(e) {
  let focusable = document
    .getElementById("primary-navigation")
    .querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
  let flag = false;

  switch (e.key) {
    case "Home":
      focusable[0].focus();
      flag = true;
      break;

    case "End":
      focusable[focusable.length - 1].focus();
      flag = true;
      break;

    case "Escape":
      toggleMenu();
      flag = true;
      break;

    default:
      break;
  }

  if (flag) {
    e.stopPropagation();
    e.preventDefault();
  }
}
