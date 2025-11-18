document.addEventListener("DOMContentLoaded", () => {
  const toastContainer = document.getElementById("toast-container");

  // === TOAST ===
  function showToast(message, type = "info") {
    if (!toastContainer) return;
    const toast = document.createElement("div");
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toastContainer.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
  }

  // === NAMA ADMIN ===
  function mintaNamaAdmin() {
    const nama = prompt("Masukkan nama admin:");
    if (nama) {
      localStorage.setItem("namaAdmin", nama);
      tampilkanNamaAdmin();
      showToast(`Selamat datang, ${nama}! `, "success");
    } else {
      showToast("Nama admin tidak dimasukkan", "error");
    }
  }

  function tampilkanNamaAdmin() {
    const namaSpan = document.getElementById("nama-admin");
    const nama = localStorage.getItem("namaAdmin") || "Admin";
    if (namaSpan) namaSpan.textContent = nama;
  }

  // Pastikan tombol ganti nama terpasang
  const gantiNamaBtn = document.getElementById("ganti-nama");
  if (gantiNamaBtn) {
    gantiNamaBtn.addEventListener("click", (e) => {
      e.preventDefault();
      mintaNamaAdmin();
    });
  }

  // Jika belum ada nama tersimpan, minta
  if (!localStorage.getItem("namaAdmin")) {
    mintaNamaAdmin();
  } else {
    tampilkanNamaAdmin();
  }

  // === JAM REALTIME ===
  function updateJam() {
    const el = document.getElementById("jam-sekarang");
    if (!el) return;
    const now = new Date();
    const hari = now.toLocaleDateString("id-ID", { weekday: "long" });
    const tanggal = now.toLocaleDateString("id-ID", { day: "numeric", month: "long", year: "numeric" });
    const waktu = now.toLocaleTimeString("id-ID");
    el.textContent = `${hari}, ${tanggal} — ${waktu}`;
  }
  updateJam();
  setInterval(updateJam, 1000);

  // === LOGOUT ===
  const logoutBtn = document.getElementById("logout-btn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
      const yakin = confirm("Apakah kamu yakin ingin keluar dari halaman admin?");
      if (yakin) {
        localStorage.clear();
        showToast("Berhasil logout 👋", "info");
        window.location.href = "../index.html";
      } else {
        showToast("Logout dibatalkan ❌", "error");
      }
    });
  }

  // === TABEL BUKU (sementara kosong / placeholder) ===
  function tampilkanDataKosong() {
    const tbody = document.querySelector("#tabel-buku tbody");
    if (!tbody) return;
    tbody.innerHTML = `<tr><td colspan="5" style="text-align:center">Data buku akan dimuat dari database.</td></tr>`;
  }

  // Inisialisasi tampilan awal
  tampilkanDataKosong();
});
