console.log("Dashboard Admin Nurussalam loaded.");

// === SPA Navigation ===
function showPage(pageId) {
    document.querySelectorAll(".page").forEach((div) => {
        div.style.display = "none";
    });
    document.getElementById(pageId).style.display = "block";

    // Panggil loader sesuai tab
    if (pageId === "dashboard") loadSummary();
    if (pageId === "jadwal") loadJadwal();
    if (pageId === "santri") loadSantri();
    if (pageId === "absensi") loadAbsensi();
    if (pageId === "pengumuman") fetchPengumuman();
}

// === DASHBOARD ===
async function loadSummary() {
    try {
        const response = await fetch(
            "http://127.0.0.1:8000/api/dashboard/summary"
        );
        const data = await response.json();
        document.getElementById("totalSantri").innerText = data.total_santri;
        document.getElementById("kehadiran").innerText = data.kehadiran + "%";
        document.getElementById("pengumuman_santri").innerText =
            data.pengumuman;
    } catch (error) {
        console.error("Gagal mengambil data dashboard:", error);
    }
}

// === JADWAL NGAJI ===
let editId = null;
async function loadJadwal() {
    try {
        const response = await fetch("http://127.0.0.1:8000/api/jadwal");
        const data = await response.json();
        const table = document.getElementById("jadwalTableBody");
        table.innerHTML = "";
        data.forEach((item, index) => {
            table.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.hari}</td>
                    <td>${item.waktu}</td>
                    <td>${item.kegiatan}</td>
                    <td>
                        <button onclick="editJadwal(${item.id}, '${
                item.hari
            }', '${item.waktu}', '${item.kegiatan}')">Edit</button>
                        <button onclick="deleteJadwal(${
                            item.id
                        })">Hapus</button>
                    </td>
                </tr>`;
        });
    } catch (err) {
        alert("Gagal memuat data jadwal!");
    }
}
document
    .getElementById("jadwalForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();
        const data = {
            hari: document.getElementById("hari").value,
            waktu: document.getElementById("waktu").value,
            kegiatan: document.getElementById("kegiatan").value,
        };
        try {
            let response;
            if (editId) {
                response = await fetch(
                    `http://127.0.0.1:8000/api/jadwal/${editId}`,
                    {
                        method: "PUT",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(data),
                    }
                );
                if (response.ok) alert("Jadwal berhasil diubah!");
                else alert("Gagal mengubah jadwal!");
                editId = null;
            } else {
                response = await fetch("http://127.0.0.1:8000/api/jadwal", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data),
                });
                if (response.ok) alert("Jadwal berhasil ditambahkan!");
                else alert("Gagal menambahkan jadwal!");
            }
            this.reset();
            loadJadwal();
        } catch (err) {
            alert("Terjadi kesalahan saat menyimpan data!");
        }
    });
window.editJadwal = function (id, hari, waktu, kegiatan) {
    document.getElementById("hari").value = hari;
    document.getElementById("waktu").value = waktu;
    document.getElementById("kegiatan").value = kegiatan;
    editId = id;
};
window.deleteJadwal = async function (id) {
    if (confirm("Yakin ingin menghapus jadwal ini?")) {
        try {
            const response = await fetch(
                `http://127.0.0.1:8000/api/jadwal/${id}`,
                {
                    method: "DELETE",
                }
            );
            if (response.ok) {
                alert("Jadwal dihapus");
                loadJadwal();
            } else {
                alert("Gagal menghapus jadwal");
            }
        } catch (err) {
            alert("Terjadi kesalahan saat menghapus data!");
        }
    }
};

// === SANTRI ===
// === SANTRI ===
let editSantriId = null;

async function loadSantri() {
    try {
        const response = await fetch("http://127.0.0.1:8000/api/santri");
        const data = await response.json();
        const table = document.getElementById("santriTableBody");
        table.innerHTML = "";
        data.forEach((item, index) => {
            table.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.nis}</td>
                    <td>${item.nama}</td>
                    <td>${item.kelas}</td>
                    <td>${item.alamat || ""}</td>
                    <td>
                        <button onclick="editSantri(${item.id}, '${
                item.nis
            }', '${item.nama}', '${item.kelas}', '${
                item.alamat || ""
            }')">Edit</button>
                        <button onclick="deleteSantri(${
                            item.id
                        })">Hapus</button>
                    </td>
                </tr>`;
        });
    } catch (err) {
        alert("Gagal memuat data santri!");
    }
}

document
    .getElementById("santriForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();
        const data = {
            nis: document.getElementById("nis").value,
            nama: document.getElementById("nama").value,
            kelas: document.getElementById("kelas").value,
            alamat: document.getElementById("alamat").value,
            password: document.getElementById("password").value,
        };
        try {
            let response;
            if (editSantriId) {
                response = await fetch(
                    `http://127.0.0.1:8000/api/santri/${editSantriId}`,
                    {
                        method: "PUT",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(data),
                    }
                );
                if (response.ok) alert("Santri berhasil diubah!");
                else alert("Gagal mengubah santri!");
                editSantriId = null;
            } else {
                response = await fetch("http://127.0.0.1:8000/api/santri", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data),
                });
                if (response.ok) alert("Santri berhasil ditambahkan!");
                else alert("Gagal menambahkan santri!");
            }
            this.reset();
            loadSantri();
        } catch (err) {
            alert("Terjadi kesalahan saat menyimpan data!");
        }
    });

window.editSantri = function (id, nis, nama, kelas, alamat) {
    document.getElementById("nis").value = nis;
    document.getElementById("nama").value = nama;
    document.getElementById("kelas").value = kelas;
    document.getElementById("alamat").value = alamat;
    editSantriId = id;
};

window.deleteSantri = async function (id) {
    if (confirm("Yakin ingin menghapus santri ini?")) {
        try {
            const response = await fetch(
                `http://127.0.0.1:8000/api/santri/${id}`,
                {
                    method: "DELETE",
                }
            );
            if (response.ok) {
                alert("Santri dihapus");
                loadSantri();
            } else {
                alert("Gagal menghapus santri");
            }
        } catch (err) {
            alert("Terjadi kesalahan saat menghapus data!");
        }
    }
};

// === ABSENSI ===
// Implementasi loadAbsensi, submit absensi, rekap, dst
// === ABSENSI ===
// ...existing code...
async function loadAbsensi() {
    // 1. Muat jadwal hari ini
    let jadwalSelect = document.getElementById("jadwalSelect"); // <-- ganti di sini
    jadwalSelect.innerHTML = "<option value=''>Pilih Jadwal</option>";
    try {
        const jadwalRes = await fetch("http://127.0.0.1:8000/api/jadwal");
        const jadwalData = await jadwalRes.json();
        jadwalData.forEach((jadwal) => {
            jadwalSelect.innerHTML += `<option value="${jadwal.id}">${jadwal.hari} - ${jadwal.waktu} (${jadwal.kegiatan})</option>`;
        });
    } catch (err) {
        jadwalSelect.innerHTML =
            "<option value=''>Gagal memuat jadwal</option>";
    }

    // 2. Muat daftar santri
    const table = document.getElementById("absensiTableBody");
    table.innerHTML =
        "<tr><td colspan='3'>Pilih jadwal untuk memuat santri...</td></tr>";

    jadwalSelect.onchange = async function () {
        if (!this.value) {
            table.innerHTML =
                "<tr><td colspan='3'>Pilih jadwal untuk memuat santri...</td></tr>";
            return;
        }
        try {
            const santriRes = await fetch("http://127.0.0.1:8000/api/santri");
            const santriData = await santriRes.json();
            table.innerHTML = "";
            santriData.forEach((santri) => {
                table.innerHTML += `
                    <tr>
                        <td>${santri.nama}</td>
                        <td>${santri.nis}</td>
                        <td>
                            <select name="status" data-nis="${santri.nis}">
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="alpha">Alpha</option>
                            </select>
                        </td>
                    </tr>
                `;
            });
        } catch (err) {
            table.innerHTML =
                "<tr><td colspan='3'>Gagal memuat santri</td></tr>";
        }
    };

    // 3. Muat rekap absensi hari ini
    fetchRekapAbsensi();
}

// Submit absensi
document
    .getElementById("absensiForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();
        const jadwalId = document.getElementById("jadwalSelect").value; // <-- ganti di sini
        if (!jadwalId) {
            alert("Pilih jadwal terlebih dahulu!");
            return;
        }
        const statusList = Array.from(
            document.querySelectorAll("#absensiTableBody select")
        );
        const data = statusList.map((sel) => ({
            nis: sel.getAttribute("data-nis"),
            status: sel.value,
            jadwal_id: jadwalId,
        }));

        try {
            const res = await fetch("http://127.0.0.1:8000/api/absensi", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ absensi: data, jadwal_id: jadwalId }),
            });
            if (res.ok) {
                alert("Absensi berhasil disimpan!");
                fetchRekapAbsensi();
            } else {
                alert("Gagal menyimpan absensi!");
            }
        } catch (err) {
            alert("Terjadi kesalahan saat menyimpan absensi!");
        }
    });
// ...existing code...
// Rekap absensi hari ini
async function fetchRekapAbsensi() {
    const rekapDiv = document.getElementById("rekapContainer");
    try {
        const res = await fetch("http://127.0.0.1:8000/api/absensi/rekap");
        const data = await res.json();
        if (!data.length) {
            rekapDiv.innerHTML = "<i>Belum ada rekap hari ini.</i>";
            return;
        }
        rekapDiv.innerHTML = data
            .map(
                (item) => `
                <div>
                    <b>${item.kegiatan}</b> (${item.waktu})<br>
                    Hadir: ${item.hadir} | Izin: ${item.izin} | Sakit: ${item.sakit} | Alpha: ${item.alpha}
                </div>
            `
            )
            .join("");
    } catch (err) {
        rekapDiv.innerHTML = "<i>Gagal memuat rekap absensi.</i>";
    }
}

// === PENGUMUMAN ===
async function fetchPengumuman() {
    const container = document.getElementById("daftarPengumuman");
    container.innerHTML = "<i>Memuat pengumuman...</i>";
    try {
        const res = await fetch("http://127.0.0.1:8000/api/pengumuman");
        const data = await res.json();
        if (!data.length) {
            container.innerHTML = "<i>Belum ada pengumuman.</i>";
            return;
        }
        container.innerHTML = `<div class="pengumuman-list">
            ${data
                .map(
                    (item) => `
                    <div class="pengumuman-card">
                        <div class="pengumuman-title">${item.judul}</div>
                        <div class="pengumuman-date">${
                            item.tanggal || item.created_at?.slice(0, 10) || ""
                        }</div>
                        <div class="pengumuman-isi">${item.isi}</div>
                        <div class="pengumuman-actions">
                            <button onclick="editPengumuman(${
                                item.id
                            })">Edit</button>
                            <button onclick="hapusPengumuman(${
                                item.id
                            })">Hapus</button>
                        </div>
                    </div>
                `
                )
                .join("")}
        </div>`;
    } catch (error) {
        container.innerHTML = "<i>Gagal memuat pengumuman.</i>";
    }
}

// Tambahkan fungsi hapus/edit jika belum ada
window.hapusPengumuman = async function (id) {
    if (!confirm("Yakin hapus pengumuman ini?")) return;
    await fetch(`http://127.0.0.1:8000/api/pengumuman/${id}`, {
        method: "DELETE",
    });
    fetchPengumuman();
};
window.editPengumuman = function (id) {
    // Implementasi edit sesuai kebutuhan Anda
    alert("Fitur edit belum diimplementasikan.");
};

// === SPA INIT ===
document.addEventListener("DOMContentLoaded", function () {
    showPage("dashboard"); // Tampilkan dashboard pertama kali
    // Jika ingin mendukung hash url, bisa tambahkan logika di sini
});

function animateValue(id, start, end, duration, suffix = "") {
    const obj = document.getElementById(id);
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerText = Math.floor(progress * (end - start) + start) + suffix;
        if (progress < 1) {
            window.requestAnimationFrame(step);
        } else {
            obj.innerText = end + suffix;
        }
    };
    window.requestAnimationFrame(step);
}

// Modifikasi loadSummary agar pakai animasi
async function loadSummary() {
    try {
        const response = await fetch(
            "http://127.0.0.1:8000/api/dashboard/summary"
        );
        const data = await response.json();
        animateValue("totalSantri", 0, data.total_santri ?? 0, 700);
        animateValue("kehadiran", 0, data.kehadiran ?? 0, 700, "%");
        animateValue("pengumuman_santri", 0, data.pengumuman ?? 0, 700);
    } catch (error) {
        document.getElementById("totalSantri").innerText = "0";
        document.getElementById("kehadiran").innerText = "0%";
        document.getElementById("pengumuman_santri").innerText = "0";
    }
}

// filepath: c:\pui\nurussalam-api\public\script.js
// ...existing code...

document.getElementById('importExcel').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, {type: 'array'});
        const sheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[sheetName];
        const json = XLSX.utils.sheet_to_json(worksheet, {header:1});
        // Asumsikan baris pertama adalah header: [NIS, Nama, Kelas, Alamat, Password]
        const santriData = [];
        for(let i=1; i<json.length; i++) {
            const row = json[i];
            if(row.length < 3) continue; // minimal NIS, Nama, Kelas
            santriData.push({
                nis: row[0],
                nama: row[1],
                kelas: row[2],
                alamat: row[3] || '',
                password: row[4] || ''
            });
        }
        // Kirim ke backend (Laravel) via API
        fetch('http://127.0.0.1:8000/api/santri/import', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            body: JSON.stringify({data: santriData})
        })
        .then(res => res.json())
        .then(res => {
            alert('Import berhasil!');
            // Refresh data santri
            // fetchSantri();
        })
        .catch(err => {
            alert('Gagal import data!');
        });
    };
    reader.readAsArrayBuffer(file);
});

// ...existing code...
// console.log("Dashboard Admin Nurussalam loaded.");

// let editId = null;

// // Muat semua data jadwal
// async function loadJadwal() {
//     try {
//         const response = await fetch("http://127.0.0.1:8000/api/jadwal");
//         const data = await response.json();
//         const table = document.getElementById("jadwalTableBody");
//         table.innerHTML = "";
//         data.forEach((item, index) => {
//             table.innerHTML += `
//                 <tr>
//                     <td>${index + 1}</td>
//                     <td>${item.hari}</td>
//                     <td>${item.waktu}</td>
//                     <td>${item.kegiatan}</td>
//                     <td>
//                         <button onclick="editJadwal(${item.id}, '${item.hari}', '${item.waktu}', '${item.kegiatan}')">Edit</button>
//                         <button onclick="deleteJadwal(${item.id})">Hapus</button>
//                     </td>
//                 </tr>`;
//         });
//     } catch (err) {
//         alert("Gagal memuat data jadwal!");
//     }
// }

// // Tambah atau update jadwal
// document.getElementById("jadwalForm").addEventListener("submit", async function (e) {
//     e.preventDefault();

//     const data = {
//         hari: document.getElementById("hari").value,
//         waktu: document.getElementById("waktu").value,
//         kegiatan: document.getElementById("kegiatan").value,
//     };

//     try {
//         let response;
//         if (editId) {
//             // UPDATE
//             response = await fetch(`http://127.0.0.1:8000/api/jadwal/${editId}`, {
//                 method: "PUT",
//                 headers: { "Content-Type": "application/json" },
//                 body: JSON.stringify(data),
//             });
//             if (response.ok) {
//                 alert("Jadwal berhasil diubah!");
//             } else {
//                 alert("Gagal mengubah jadwal!");
//             }
//             editId = null;
//         } else {
//             // CREATE
//             response = await fetch("http://127.0.0.1:8000/api/jadwal", {
//                 method: "POST",
//                 headers: { "Content-Type": "application/json" },
//                 body: JSON.stringify(data),
//             });
//             if (response.ok) {
//                 alert("Jadwal berhasil ditambahkan!");
//             } else {
//                 alert("Gagal menambahkan jadwal!");
//             }
//         }
//         this.reset();
//         loadJadwal();
//     } catch (err) {
//         alert("Terjadi kesalahan saat menyimpan data!");
//     }
// });

// // Hapus jadwal
// async function deleteJadwal(id) {
//     if (confirm("Yakin ingin menghapus jadwal ini?")) {
//         try {
//             const response = await fetch(`http://127.0.0.1:8000/api/jadwal/${id}`, {
//                 method: "DELETE",
//             });
//             if (response.ok) {
//                 alert("Jadwal dihapus");
//                 loadJadwal();
//             } else {
//                 alert("Gagal menghapus jadwal");
//             }
//         } catch (err) {
//             alert("Terjadi kesalahan saat menghapus data!");
//         }
//     }
// }

// // Edit jadwal
// function editJadwal(id, hari, waktu, kegiatan) {
//     document.getElementById("hari").value = hari;
//     document.getElementById("waktu").value = waktu;
//     document.getElementById("kegiatan").value = kegiatan;
//     editId = id;
// }

// // Muat data saat halaman dibuka
// document.addEventListener('DOMContentLoaded', function() {
//     loadJadwal();
// });

// // // script.js
// // console.log("Dashboard Admin Nurussalam loaded.");

// // // Future interactive features (like toggle sidebar or fetch data) can go here.
// // // Fungsi memuat data dari API
// // let editId = null;

// // // Muat semua data jadwal
// // async function loadJadwal() {
// //     const response = await fetch("http://127.0.0.1:8000/api/jadwal");
// //     const data = await response.json();
// //     const table = document.getElementById("jadwalTableBody");
// //     table.innerHTML = "";
// //     data.forEach((item, index) => {
// //         table.innerHTML += `
// //       <tr>
// //         <td>${index + 1}</td>
// //         <td>${item.hari}</td>
// //         <td>${item.waktu}</td>
// //         <td>${item.kegiatan}</td>
// //         <td>
// //           <button onclick="editJadwal(${item.id}, '${item.hari}', '${
// //             item.waktu
// //         }', '${item.kegiatan}')">Edit</button>
// //           <button onclick="deleteJadwal(${item.id})">Hapus</button>
// //         </td>
// //       </tr>`;
// //     });
// // }

// // // Fungsi menambahkan atau mengupdate jadwal
// // document
// //     .getElementById("jadwalForm")
// //     .addEventListener("submit", async function (e) {
// //         e.preventDefault();

// //         const data = {
// //             hari: document.getElementById("hari").value,
// //             waktu: document.getElementById("waktu").value,
// //             kegiatan: document.getElementById("kegiatan").value,
// //         };

// //         if (editId) {
// //             // UPDATE
// //             const response = await fetch(
// //                 `http://127.0.0.1:8000/api/jadwal/${editId}`,
// //                 {
// //                     method: "PUT",
// //                     headers: { "Content-Type": "application/json" },
// //                     body: JSON.stringify(data),
// //                 }
// //             );

// //             if (response.ok) {
// //                 alert("Jadwal berhasil diubah!");
// //             } else {
// //                 alert("Gagal mengubah jadwal!");
// //             }
// //             editId = null;
// //         } else {
// //             // CREATE
// //             const response = await fetch("http://127.0.0.1:8000/api/jadwal", {
// //                 method: "POST",
// //                 headers: { "Content-Type": "application/json" },
// //                 body: JSON.stringify(data),
// //             });

// //             if (response.ok) {
// //                 alert("Jadwal berhasil ditambahkan!");
// //             } else {
// //                 alert("Gagal menambahkan jadwal!");
// //             }
// //         }

// //         this.reset();
// //         loadJadwal();
// //     });

// // // Fungsi menghapus jadwal
// // async function deleteJadwal(id) {
// //     if (confirm("Yakin ingin menghapus jadwal ini?")) {
// //         const response = await fetch(`http://127.0.0.1:8000/api/jadwal/${id}`, {
// //             method: "DELETE",
// //         });

// //         if (response.ok) {
// //             alert("Jadwal dihapus");
// //             loadJadwal();
// //         } else {
// //             alert("Gagal menghapus jadwal");
// //         }
// //     }
// // }

// // // Fungsi edit jadwal
// // function editJadwal(id, hari, waktu, kegiatan) {
// //     document.getElementById("hari").value = hari;
// //     document.getElementById("waktu").value = waktu;
// //     document.getElementById("kegiatan").value = kegiatan;
// //     editId = id;
// // }

// // document.addEventListener('DOMContentLoaded', function() {
// //     loadJadwal();
// // });
