function toggleMenu() {
  let button = document.getElementById("nav-button");
  let menu = document.getElementById("primary-navigation");
  let overlay = document.querySelector("#nav-button + .menu-overlay");
  let isOpen = button.getAttribute("aria-expanded") == "true";
  if (isOpen) {
    button.setAttribute("aria-expanded", "false");
    menu.dataset.state = "closed";
    overlay.dataset.state = "closed";
    document.documentElement.style.overflow = "";
    document.body.style.position = "";
    document.body.style.inset = "";
    document.body.style.pointerEvents = "";
  } else {
    button.setAttribute("aria-expanded", "true");
    menu.dataset.state = "open";
    overlay.dataset.state = "open";
    document.documentElement.style.overflow = "hidden";
    document.body.style.position = "fixed";
    document.body.style.inset = "0";
    document.body.style.pointerEvents = "none";
  }
}
