📄 ARSINTRA – Arus Surat Terintegrasi
---
# A. Deskripsi Singkat “Arsintra”
Sistem ARSINTRA dipilih karena mampu mempermudah proses administrasi dan pengelolaan arsip surat masuk dan keluar yang sebelumnya dilakukan secara manual, dengan sistem berbasis web menggunakan PHP dan MySQL yang memungkinkan pencatatan surat, pengelompokan data, pencarian arsip, serta manajemen pengguna dilakukan secara cepat, akurat, dan efisien, sekaligus mengurangi human error dan menyediakan akses data yang terstruktur dan mudah diakses kapan saja untuk mendukung kinerja instansi secara optimal.


# B. Penjelasan dan Relasi Database
# 1. Entitas dan Atribut
a. Users

Tabel ini menyimpan data akun pengguna sistem.
- Atribut penting: id, username, password, nama_lengkap, email, role
- Nilai role terdiri dari: admin, petugas
  
b. Surat Masuk

Tabel ini menyimpan data terkait surat masuk yang diterima oleh instansi.
- Atribut penting: id, nomor_surat, asal_surat, nama_surat, kategori, tanggal_masuk, tanggal_terima, status, created_by
  
c. Surat Keluar

Tabel ini menyimpan informasi mengenai surat yang dikeluarkan oleh instansi.
- Atribut penting: id, nomor_surat, nama_surat, kategori, tanggal_keluar, tujuan_surat, status, created_by

d. Disposisi

Tabel ini mencatat hasil tindak lanjut dari surat masuk (disposisi).
- Atribut penting: id, surat_masuk_id, nomor_disposisi, tanggal_disposisi, isi_disposisi, status, created_by

# 2. Relasi Antar Entitas 
| Entitas 1      | Relasi | Entitas 2      | Deskripsi                                               |
|----------------|--------|----------------|----------------------------------------------------------|
| Users          | 1 : N  | Surat Masuk    | Satu pengguna dapat membuat banyak surat masuk          |
| Users          | 1 : N  | Surat Keluar   | Satu pengguna dapat membuat banyak surat keluar         |
| Users          | 1 : N  | Disposisi      | Satu pengguna dapat membuat banyak disposisi            |
| Surat Masuk    | 1 : N  | Disposisi      | Satu surat masuk dapat memiliki banyak disposisi        |

# 3. Aktor Sistem
  1. Admin : Admin tugasnya adalah mengelola akun dari user nya baik itu akun sebagai admin maupun admin sebagai users (petugas arsip).

  2. Users (Petugas Arsip) : Mengelola surat masuk, surat keluar, disposisi, dan melakukan pengarsipan surat yang otomatis terbuat jika menginput atau melakukan CRUD di surat masuk,keluar dan disposisi.


