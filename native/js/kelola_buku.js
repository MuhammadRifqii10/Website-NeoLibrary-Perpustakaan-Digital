document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-tambah-buku");
  const tableBody = document.querySelector("#tabel-buku tbody");
  const toastContainer = document.getElementById("toast-container");

  // === Toast Notifikasi ===
  function showToast(message, type = "info") {
    const toast = document.createElement("div");
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toastContainer.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
  }

  // === Ambil data buku dari localStorage ===
  function ambilDataBuku() {
    return JSON.parse(localStorage.getItem("dataBuku")) || [];
  }

  // === Simpan data buku ke localStorage ===
  function simpanDataBuku(data) {
    localStorage.setItem("dataBuku", JSON.stringify(data));
  }

  // === Tampilkan data di tabel ===
  function tampilkanDataBuku() {
    const dataBuku = ambilDataBuku();
    tableBody.innerHTML = "";

    if (dataBuku.length === 0) {
      tableBody.innerHTML = `<tr><td colspan="5" style="text-align:center;">Belum ada data buku.</td></tr>`;
      return;
    }

    dataBuku.forEach((buku, index) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${buku.judul}</td>
        <td>${buku.penulis}</td>
        <td>${buku.kategori}</td>
        <td>
          <button class="aksi-btn" data-index="${index}">Hapus</button>
        </td>
      `;
      tableBody.appendChild(row);
    });

    document.querySelectorAll(".aksi-btn").forEach(btn => {
      btn.addEventListener("click", e => {
        const index = e.target.getAttribute("data-index");
        hapusBuku(index);
      });
    });
  }

  // === Tambah Buku ===
  form.addEventListener("submit", e => {
    e.preventDefault();
    const judul = document.getElementById("judul").value.trim();
    const penulis = document.getElementById("penulis").value.trim();
    const kategori = document.getElementById("kategori").value.trim();

    if (!judul || !penulis || !kategori) {
      showToast("Isi semua kolom sebelum menambah buku!", "error");
      return;
    }

    const dataBuku = ambilDataBuku();
    dataBuku.push({ judul, penulis, kategori });
    simpanDataBuku(dataBuku);
    tampilkanDataBuku();
    showToast(`Buku "${judul}" berhasil ditambahkan 📖`, "success");

    form.reset();
  });

  // === Hapus Buku ===
  function hapusBuku(index) {
    const dataBuku = ambilDataBuku();
    const bukuDihapus = dataBuku[index];
    if (!bukuDihapus) return;

    const konfirmasi = confirm(`Yakin ingin menghapus buku "${bukuDihapus.judul}"?`);
    if (!konfirmasi) return;

    dataBuku.splice(index, 1);
    simpanDataBuku(dataBuku);
    tampilkanDataBuku();
    showToast(`Buku "${bukuDihapus.judul}" telah dihapus ❌`, "error");
  }

  tampilkanDataBuku();
});
