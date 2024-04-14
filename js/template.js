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
