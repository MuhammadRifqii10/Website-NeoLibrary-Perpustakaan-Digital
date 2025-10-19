document.addEventListener("DOMContentLoaded", async () => {
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
      showToast(`Selamat datang, ${nama}! 🎉`, "success");
    } else {
      showToast("Nama admin tidak dimasukkan ❌", "error");
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

  // === JAM REALTIME (ID sesuai admin.html: "jam-sekarang") ===
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

  // === DATA BUKU: inisialisasi hanya bila localStorage belum ada sama sekali ===
  async function inisialisasiDataBuku() {
    try {
      // Periksa apakah key sudah pernah dibuat (null = belum pernah)
      const raw = localStorage.getItem("dataBuku");
      if (raw === null) {
        // pertama kali: ambil dari JSON dan simpan ke localStorage
        const response = await fetch("../data/data-buku.json");
        if (!response.ok) throw new Error("Gagal fetch data-buku.json");
        const data = await response.json();
        localStorage.setItem("dataBuku", JSON.stringify(data));
        showToast("Data buku berhasil dimuat dari file JSON 📖", "success");
        return data;
      } else {
        // sudah pernah ada (meskipun bisa berupa '[]'), gunakan apa yang ada
        try {
          return JSON.parse(raw);
        } catch (e) {
          // jika parsing gagal, reset dengan array kosong
          localStorage.setItem("dataBuku", JSON.stringify([]));
          return [];
        }
      }
    } catch (err) {
      console.error(err);
      showToast("Gagal memuat data buku ⚠️", "error");
      // fallback agar fungsi lain masih dapat berjalan
      return JSON.parse(localStorage.getItem("dataBuku") || "[]");
    }
  }

  // === tampilkanDataBuku selalu menerima array (fallback []) ===
  function tampilkanDataBuku(dataArray) {
    const tbody = document.querySelector("#tabel-buku tbody");
    if (!tbody) return;
    const data = Array.isArray(dataArray) ? dataArray : [];
    tbody.innerHTML = "";

    if (data.length === 0) {
      tbody.innerHTML = `<tr><td colspan="5" style="text-align:center">Belum ada data buku.</td></tr>`;
      return;
    }

    data.forEach((buku, i) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${i + 1}</td>
        <td>${buku.judul || "-"}</td>
        <td>${buku.penulis || "-"}</td>
        <td>${buku.kategori || "-"}</td>
        <td><button class="aksi-btn" data-index="${i}">Hapus</button></td>
      `;
      tbody.appendChild(tr);
    });

    // pasang event listener HAPUS setiap render
    tbody.querySelectorAll(".aksi-btn").forEach(btn => {
      btn.addEventListener("click", (e) => {
        const idx = parseInt(e.currentTarget.dataset.index, 10);
        if (Number.isNaN(idx)) return;
        hapusBuku(idx);
      });
    });
  }

  // === HAPUS BUKU (update localStorage dan re-render) ===
  function hapusBuku(index) {
    const raw = localStorage.getItem("dataBuku");
    let data = [];
    try {
      data = JSON.parse(raw) || [];
    } catch (e) {
      data = [];
    }
    if (!data[index]) {
      showToast("Data tidak ditemukan ❌", "error");
      return;
    }
    const judul = data[index].judul || "Buku";
    if (!confirm(`Yakin ingin menghapus "${judul}"?`)) return;
    data.splice(index, 1);
    localStorage.setItem("dataBuku", JSON.stringify(data));
    showToast(`"${judul}" dihapus ❌`, "error");
    tampilkanDataBuku(data);
  }

  // === INISIALISASI UTAMA ===
  const buku = await inisialisasiDataBuku(); // array atau []
  tampilkanDataBuku(buku);
});
