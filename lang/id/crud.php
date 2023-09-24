<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'artikel' => [
        'name' => 'Artikel',
        'index_title' => 'Daftar Artikel',
        'new_title' => 'Artikel Baru',
        'create_title' => 'Tambah Artikel',
        'edit_title' => 'Edit Artikel',
        'show_title' => 'Tampilkan Artikel',
        'inputs' => [
            'title' => 'Judul',
            'banner' => 'Gambar Banner',
            'user_id' => 'User',
            'date' => 'Tanggal',
            'content' => 'Konten Artikel',
        ],
    ],

    'quote' => [
        'name' => 'Quote',
        'index_title' => 'Daftar Quote',
        'new_title' => 'Quote Baru',
        'create_title' => 'Tambah Quote',
        'edit_title' => 'Edit Quote',
        'show_title' => 'Tampilkan Quote',
        'inputs' => [
            'quote' => 'Quote',
            'date' => 'Tanggal',
            'teacher_id' => 'Guru',
        ],
    ],
    
    'prestasi' => [
        'name' => 'Prestasi',
        'index_title' => 'Daftar Prestasi',
        'new_title' => 'Prestasi Baru',
        'create_title' => 'Buat Daftar Prestasi',
        'edit_title' => 'Edit Prestasi',
        'show_title' => 'Tampilkan Prestasi',
        'inputs' => [
            'name' => 'Nama Prestasi',
            'point' => 'Poin',
        ],
    ],

    'data_prestasi' => [
        'name' => 'Data Prestasi',
        'index_title' => 'Daftar Data Prestasi',
        'new_title' => 'Data Prestasi Baru',
        'create_title' => 'Buat Data Prestasi',
        'edit_title' => 'Edit Data Prestasi',
        'show_title' => 'Tampilkan Data Prestasi',
        'inputs' => [
            'achievment_id' => 'Prestasi',
            'student_id' => 'Siswa',
            'teacher_id' => 'Guru',
            'date' => 'Tanggal',
            'description' => 'Keterangan',
        ],
    ],

    'data_tugas' => [
        'name' => 'Data Tugas',
        'index_title' => 'Daftar Data Tugas',
        'new_title' => 'Data Tugas Baru',
        'create_title' => 'Buat Data Tugas',
        'edit_title' => 'Edit Data Tugas',
        'show_title' => 'Tampilkan Data Tugas',
        'inputs' => [
            'task_id' => 'Tugas',
            'student_id' => 'Siswa',
            'teacher_id' => 'Guru',
            'date' => 'Tanggal',
            'description' => 'Keterangan',
        ],
    ],

    'data_pelanggaran' => [
        'name' => 'Data Pelanggaran',
        'index_title' => 'Daftar Data Pelanggaran',
        'new_title' => 'Data Pelaggaran Baru',
        'create_title' => 'Buat Data Pelanggaran',
        'edit_title' => 'Edit Data Pelanggaran',
        'show_title' => 'Tampilkan Data Pelanggaran',
        'inputs' => [
            'violation_id' => 'Pelanggaran',
            'student_id' => 'Siswa',
            'teacher_id' => 'Guru',
            'date' => 'Tanggal',
            'description' => 'Keterangan',
        ],
    ],

    'wali_kelas' => [
        'name' => 'Wali Kelas',
        'index_title' => 'Daftar Wali Kelas',
        'new_title' => 'Wali Kelas Baru',
        'create_title' => 'Buat Wali Kelas',
        'edit_title' => 'Edit Wali Kelas',
        'show_title' => 'Tampilkan Wali Kelas',
        'inputs' => [
            'teacher_id' => 'Guru',
            'class_id' => 'Kelas',
        ],
    ],

    'pelanggaran' => [
        'name' => 'Pelanggaran',
        'index_title' => 'Daftar Pelanggaran',
        'new_title' => 'Pelanggaran Baru',
        'create_title' => 'Buat Pelanggaran',
        'edit_title' => 'Edit Pelanggaran',
        'show_title' => 'Tampilkan Pelanggaran',
        'inputs' => [
            'name' => 'Nama Pelanggaran',
            'point' => 'Poin',
        ],
    ],

    'kelas' => [
        'name' => 'Kelas',
        'index_title' => 'Daftar Kelas',
        'new_title' => 'Kelas Baru',
        'create_title' => 'Buat Kelas',
        'edit_title' => 'Edit Kelas',
        'show_title' => 'Tampilkan Kelas',
        'inputs' => [
            'name' => 'Nama Kelas',
            'code' => 'Kode/Singkatan Kelas',
        ],
    ],

    'catatan_scan_prestasi' => [
        'name' => 'Catatan Scan Prestasi',
        'index_title' => 'Daftar Catatan Scan Prestasi',
        'new_title' => 'Catatan Scan Prestasi Baru',
        'create_title' => 'Buat Catatan Scan Prestasi',
        'edit_title' => 'Edit Catatan Scan Prestasi',
        'show_title' => 'Tampilkan Catatan Scan Prestasi',
        'inputs' => [
            'student_id' => 'Siswa',
            'teacher_id' => 'Guru',
            'achievment_id' => 'Prestasi',
            'date' => 'Tanggal',
        ],
    ],

    'catatan_scan_tugas' => [
        'name' => 'Catatan Scan Tugas',
        'index_title' => 'Daftar Catatan Scan Tugas',
        'new_title' => 'Catatan Scan Tugas Baru',
        'create_title' => 'Buat Catatan Scan Tugas',
        'edit_title' => 'Edit Catatan Scan Tugas',
        'show_title' => 'Tampilkan Catatan Scan Tugas',
        'inputs' => [
            'student_id' => 'Siswa',
            'teacher_id' => 'Guru',
            'task_id' => 'Tugas',
            'date' => 'Tanggal',
        ],
    ],

    'catatan_scan_pelanggaran' => [
        'name' => 'Catatan Scan Pelanggaran',
        'index_title' => 'Daftar Catatan Scan Pelanggaran',
        'new_title' => 'Catatan Scan Pelanggaran Baru',
        'create_title' => 'Buat Catatan Scan Pelanggaran',
        'edit_title' => 'Edit Catatan Scan Pelanggaran',
        'show_title' => 'Tampilkan Catatan Scan Pelanggaran',
        'inputs' => [
            'student_id' => 'Siswa',
            'teacher_id' => 'Guru',
            'violation_id' => 'Pelanggaran ',
            'date' => 'Date',
        ],
    ],

    'tugas' => [
        'name' => 'Tugas',
        'index_title' => 'Daftar Tugas',
        'new_title' => 'Tugas Baru',
        'create_title' => 'Buat Tugas',
        'edit_title' => 'Edit Tugas',
        'show_title' => 'Tampilkan Tugas',
        'inputs' => [
            'name' => 'Nama',
            'class' => 'Kelas',
            'description' => 'Deskripsi',
        ],
    ],

    'guru' => [
        'name' => 'Guru',
        'index_title' => 'Daftar Guru',
        'new_title' => 'Guru Baru',
        'create_title' => 'Buat Guru',
        'edit_title' => 'Edit Guru',
        'show_title' => 'Tampilkan Guru',
        'inputs' => [
            'email' => 'Email',
            'name' => 'Nama',
            'password' => 'Password',
            'password_show' => 'Password Show',
            'image' => 'Gambar Profil',
            'gender' => 'Gender',
        ],
    ],

    'siswa' => [
        'name' => 'Siswa',
        'index_title' => 'Daftar Siswa',
        'new_title' => 'Siswa Baru',
        'create_title' => 'Buat Siswa',
        'edit_title' => 'Edit Siswa',
        'show_title' => 'Tampilkan Siswa',
        'inputs' => [
            'nis' => 'Nis',
            'name' => 'Nama',
            'password' => 'Password',
            'password_show' => 'Password Show',
            'image' => 'Gambar Profil',
            'gender' => 'Gender',
            'class_id' => 'Kelas',
            'code' => 'Kode',
        ],
    ],

    'user' => [
        'name' => 'User',
        'index_title' => 'Daftar User',
        'new_title' => 'User Baru',
        'create_title' => 'Buat User',
        'edit_title' => 'Edit User',
        'show_title' => 'Tampilkan User',
        'inputs' => [
            'name' => 'Nama',
            'password' => 'Password',
            'email' => 'Email',
        ],
    ],

    'jenis_kehadiran' => [
        'name' => 'Jenis Kehadiran',
        'index_title' => 'Daftar Jenis Kehadiran',
        'new_title' => 'Jenis Kehadiran Baru',
        'create_title' => 'Buat Jenis Kehadiran',
        'edit_title' => 'Edit Jenis Kehadiran',
        'show_title' => 'Tampilkan Jenis Kehadiran',
        'inputs' => [
            'name' => 'Nama Kehadiran',
        ],
    ],

  

    'absensi_siswa' => [
        'name' => 'Absensi Siswa',
        'index_title' => 'Daftar Absensi Siswa',
        'new_title' => 'Absensi Siswa Baru',
        'create_title' => 'Buat Absensi Siswa',
        'edit_title' => 'Edit Absensi Siswa',
        'show_title' => 'Tampilkan Absensi Siswa',
        'inputs' => [
            'date' => 'Tanggal',
            'student_id' => 'Siswa',
            'presence_id' => 'Kehadiran',
            'time' => 'Jam',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
