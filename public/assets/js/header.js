document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburger-btn");
  const closeBtn = document.getElementById("close-menu-btn");
  const navMenu = document.getElementById("nav-menu");
  const overlay = document.getElementById("overlay");

  function toggleMenu() {
    navMenu.classList.toggle("active");
    overlay.classList.toggle("active");
    document.body.style.overflow = navMenu.classList.contains("active")
      ? "hidden"
      : "";
  }

  if (hamburger) hamburger.addEventListener("click", toggleMenu);
  if (closeBtn) closeBtn.addEventListener("click", toggleMenu);
  if (overlay) overlay.addEventListener("click", toggleMenu);
});
