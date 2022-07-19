<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tiket</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .card {
            min-width: auto !important;
            margin-right: 1rem !important;
            box-shadow: 5px 5px 10px grey;
        }

        body {
            background-color: #ededed;
        }

        form>*:nth-last-child(n+2) {
            margin-bottom: .75rem;
        }
    </style>
    <script>
        // function format title case
        function titleCase(str) {
            return str.toLowerCase().split(' ').map(function(word) {
                return (word.charAt(0).toUpperCase() + word.slice(1));
            }).join(' ');
        }
        // end function format title case

        // function format to currency
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',

            // These options are needed to round to whole numbers if that's what you want.
            //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
        });
        // end function format to currency

        $(document).ready(() => {
            SetCurrency();

            var selectOptions = document.querySelectorAll('option');
            for (var i = 0; i < selectOptions.length; i++) {
                var selectOption = selectOptions[i];
                selectOption.innerText = titleCase(selectOption.innerText);
            }

            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.querySelectorAll('.needs-validation')

                // Loop over them and prevent submission
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
            // end Example starter JavaScript for disabling form submissions if there are invalid fields

            // set tanggal keberangkatan min date
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById("jadwalKeberangkatan").setAttribute("min", today);
            // end set tanggal keberangkatan min date
        });

        // function set currency to rupiah
        function SetCurrency() {
            var elemen2Harga = document.getElementsByClassName('harga');
            for (var i = 0; i < elemen2Harga.length; i++) {
                var elemenHarga = elemen2Harga[i];
                elemenHarga.value = formatter.format(elemenHarga.value);
            }
        }
        // end function set currency to rupiah

        // function hitung total bayar
        function Hitung() {
            // lansia diskon 10%
            var elemenKelas = document.getElementById('kelas');
            var elemenHargaTiket = document.getElementById('hargaTiket');
            var elemenTotalBayar = document.getElementById('totalBayar');
            var elemenJumlahPenumpang = document.getElementById('jumlahPenumpang');
            var elemenJumlahPenumpangLansia = document.getElementById('jumlahPenumpangLansia');

            var jumlahPenumpang = elemenJumlahPenumpang.value;
            var jumlahPenumpangLansia = elemenJumlahPenumpangLansia.value;

            <?php
            include('koneksi.php');
            $result = mysqli_query($koneksi, "SELECT * FROM bus");
            $buses = array();
            while ($row = $result->fetch_assoc()) {
                $buses[] = $row;
            }
            
            ?>
            var buses = JSON.parse('<?php echo json_encode($buses); ?>');
            var bus = FindBus(elemenKelas.value, buses);
            
            elemenHargaTiket.value = bus.harga;

            var totalBayar = (bus.harga * jumlahPenumpang) + ((bus.harga * 0.9)* jumlahPenumpangLansia);
            elemenTotalBayar.value = totalBayar;
            SetCurrency();

            var elemenHiddenHargaTiket = document.getElementById('hiddenHargaTiket');
            var elemenHiddenTotalBayar = document.getElementById('hiddenTotalBayar');

            elemenHiddenHargaTiket.value = bus.harga;
            elemenHiddenTotalBayar.value = totalBayar;
        }
        // end function hitung total bayar

        // function cari bus
        function FindBus(id, buses) {
            for (var i = 0; i < buses.length; i++) {
                var bus = buses[i];
                if (bus.id == id) {
                    return bus;
                }
            }
        }
        // end function cari bus
    </script>
</head>

<body>
    <?php include('koneksi.php'); ?>
    <div class="mx-3 my-3 main-content">
        <h1>Form Tiket</h1>
        <div class="d-flex mt-3 card">
            <div class="card-body">
                <form action="pesanTiket.php" method="post" id="formTiket" class="needs-validation" novalidate>
                    <div class="input-group">
                        <label class="input-group-text col-2">Nama Lengkap</label>
                        <input class="form-control col-10" type="text" name="namaLengkap" maxlength="50" pattern="[A-Za-z'. ]+" minlength="1" placeholder="John Doe" required />
                        <div class="invalid-feedback">
                            Mohon isi nama lengkap anda menggunakan alfabet!
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text col-2">Nomor Identitas</label>
                        <input class="form-control col-10" type="text" name="nomorIdentitas" minlength="16" maxlength="16" pattern="[0-9]+" minlength="1" placeholder="0000000000000000" required />
                        <div class="invalid-feedback">
                            Mohon isi nomor identitas (NIK) anda sebanyak 16 digit menggunakan angka!
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text col-2">Nomor HP</label>
                        <input class="form-control col-10" type="text" name="nomorHP" minlength="11" maxlength="15" pattern="[0-9]+" minlength="1" placeholder="08xxxxxxxxx" required />
                        <div class="invalid-feedback">
                            Mohon isi nomor HP anda menggunakan angka!
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text col-2">Kelas Penumpang</label>
                        <select id="kelas" name="kelas" class="form-select col-10" onchange="Hitung()">
                            <?php
                            $buses = mysqli_query($koneksi, "SELECT * FROM bus");
                            foreach ($buses as $bus) {
                            ?>
                                <option value="<?php echo $bus['id']; ?>"><?php echo $bus['kelas']; ?> - <?php echo $bus['nama']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Mohon pilih kelas penumpang anda!
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text col-2">Jadwal Keberangkatan</label>
                        <input class="form-control col-10" type="date" id="jadwalKeberangkatan" name="jadwalKeberangkatan" min="today" required />
                        <div class="invalid-feedback">
                            Mohon pilih tanggal keberangkatan anda!
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text col-2">Jumlah Penumpang</label>
                        <input class="form-control col-10" type="number" id="jumlahPenumpang" name="jumlahPenumpang" min="0" value="0" onchange="Hitung()" required />
                        <div class="invalid-feedback">
                            Mohon isi jumlah penumpang!
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text col-2">Jumlah Penumpang Lansia</label>
                        <input class="form-control col-10" type="number" id="jumlahPenumpangLansia" name="jumlahPenumpangLansia" min="0" value="0" onchange="Hitung()" required />
                        <div class="invalid-feedback">
                            Mohon isi jumlah penumpang lansia!
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text col-2">Harga Tiket</label>
                        <input class="form-control col-10 harga" type="text" id="hargaTiket" disabled />
                    </div>

                    <div class="input-group">
                        <label class="input-group-text col-2">Total Bayar</label>
                        <input class="form-control col-10 harga" type="text" id="totalBayar" disabled />
                    </div>

                    <input type="hidden" id="hiddenHargaTiket" name="hargaTiket" />
                    <input type="hidden" id="hiddenTotalBayar" name="totalBayar" />

                    <div class="mt-3">
                        <button class="btn btn-danger" onclick="javascript: window.location = 'daftarBus.php'">Batal</button>
                        <input type="submit" class="btn btn-success" value="Pesan" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>