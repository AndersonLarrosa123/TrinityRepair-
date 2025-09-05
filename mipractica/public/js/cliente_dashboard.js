// Splash screen ocultar
window.addEventListener("load", () => {
  setTimeout(() => {
    const splash = document.getElementById("splash");
    splash.style.opacity = "0";
    setTimeout(() => splash.style.display = "none", 300);
  }, 600);
});

// Modo oscuro / claro
const themeBtn = document.getElementById("toggleTheme");
const userPref = localStorage.getItem("theme");

if (userPref === "light") {
  document.body.classList.add("light-mode");
  themeBtn.textContent = "☀️";
}

themeBtn.addEventListener("click", () => {
  document.body.classList.toggle("light-mode");
  const isLight = document.body.classList.contains("light-mode");
  themeBtn.textContent = isLight ? "☀️" : "🌙";
  localStorage.setItem("theme", isLight ? "light" : "dark");
});
