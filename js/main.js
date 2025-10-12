document.addEventListener("DOMContentLoaded", () => {
  const toastContainer = document.getElementById("toast-container");
  const themeBtn = document.getElementById("theme-btn");
  const themeLabel = document.getElementById("theme-label");
  const searchInput = document.getElementById("search-input");
  const searchBtn = document.getElementById("search-btn");
  const toggleDescBtn = document.getElementById("toggle-desc-btn");
  const heroDesc = document.getElementById("hero-desc");

  // === TOAST / SNACKBAR ===
  function showToast(message, type = "info") {
    const toast = document.createElement("div");
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toastContainer.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
  }

  // === GANTI MODE TEMA ===
  themeBtn.addEventListener("click", () => {
    const isDark = document.body.classList.toggle("dark-theme");
    themeBtn.classList.toggle("active", isDark);
    themeLabel.textContent = isDark ? "Mode Gelap 🌙" : "Mode Terang ☀️";
    showToast(isDark ? "Tema Gelap Aktif 🌙" : "Tema Terang Aktif ☀️", "success");
  });

  // === FITUR PENCARIAN ===
  searchBtn.addEventListener("click", () => {
    const keyword = searchInput.value.trim();
    if (keyword) {
      showToast(`Mencari buku "${keyword}" 🔍`, "info");
    } else {
      showToast("Masukkan kata kunci terlebih dahulu.", "error");
    }
  });

// === SEMBUNYIKAN / TAMPILKAN DESKRIPSI (TEKS MINIMALIS) ===
toggleDescBtn.addEventListener("click", () => {
  heroDesc.classList.toggle("hidden");

  if (heroDesc.classList.contains("hidden")) {
    toggleDescBtn.textContent = "Tampilkan";
    toggleDescBtn.title = "Tampilkan deskripsi";
    showToast("Deskripsi disembunyikan 📖", "info");
  } else {
    toggleDescBtn.textContent = "Sembunyikan";
    toggleDescBtn.title = "Sembunyikan deskripsi";
    showToast("Deskripsi ditampilkan kembali ✨", "success");
  }
});

});
