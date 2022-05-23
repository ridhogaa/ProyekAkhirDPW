REST API JASR-TECH Kelompok 5

-- Read Single Request
Root : http://localhost/proyek-dpw/api-product/detail.php?id_akun=4

-- List Request
Root : http://localhost/proyek-dpw/api-product/list.php

-- Create Request
Root : http://localhost/proyek-dpw/api-product/create.php
Edit in Body
Examples : {
                "id_akun": "5",
                "email": "jovian@gmail.com",
                "no_telp": "089500004444",
                "password": "1234"
            }

-- Update Request
Root : http://localhost/proyek-dpw/api-product/update.php
Edit in Body
Examples : {
                "email": "angga@yahoo.com",
                "no_telp": "08192316132",
                "password": "lol123",
                "id_akun": "5"
            }

-- Delete Request
Root : http://localhost/proyek-dpw/api-product/delete.php
Edit in Body
Examples : {
                "id_akun": "5"
            }