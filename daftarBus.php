<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Bus</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .carousel {
            overflow: hidden;
            height: 50vh;
            width: 600px;
        }

        .card {
            min-width: auto !important;
            margin-right: 1rem !important;
            box-shadow: 5px 5px 10px grey;
        }

        .carousel-item img {
            width: 600px;
            height: 400px;
            object-fit: cover;
        }

        .card-parent {
            width: min-content;
        }

        body {
            background-color: #ededed;
        }
    </style>
    <script>
        // horizontal scroll
        window.addEventListener('wheel', function(event) {
            //console.log(this.scrollX + event.deltaY, event.deltaY);
            if (this.scrollX + event.deltaY < 0) {
                this.scrollX = 0;
            } else if (this.scrollX + event.deltaY > (window.screen.width - this.scrollX - event.deltaY - event.deltaY)) {
                this.scrollX = (window.screen.width - this.scrollX);
            } else {
                this.scrollX += (event.deltaY);
            }
            this.scrollTo(this.scrollX, 0);
            event.preventDefault();
        }, {
            passive: false
        });
        // end horizontal scroll

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
            var elemen2Harga = document.getElementsByClassName('harga');
            for (var i = 0; i < elemen2Harga.length; i++) {
                var elemenHarga = elemen2Harga[i];
                elemenHarga.innerText = formatter.format(elemenHarga.innerText);
            }

            var elemen2Title = document.getElementsByClassName('card-title');
            for (var i = 0; i < elemen2Title.length; i++) {
                var elemenTitle = elemen2Title[i];
                elemenTitle.innerText = titleCase(elemenTitle.innerText);
            }
        });
    </script>
</head>

<body>
    <div class="mx-3 my-3 main-content">
        <h1>Daftar Bus</h1>
        <div class="d-flex flex-row card-parent mt-3">
            <?php
            include('koneksi.php');
            $buses = mysqli_query($koneksi, "SELECT * FROM bus");
            foreach ($buses as $bus) {
            ?>
                <div class="card">
                    <div id="carouselBus<?php echo $bus['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselBus<?php echo $bus['id'] ?>" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselBus<?php echo $bus['id'] ?>" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselBus<?php echo $bus['id'] ?>" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="images/a1.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="images/a2.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="images/a3.webp" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselBus<?php echo $bus['id'] ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselBus<?php echo $bus['id'] ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title"><?php echo $bus['nama'] ?></h6>
                        <p class="card-text">Bus dengan kelas <?php echo $bus['kelas'] ?></p>
                        <p class="card-text harga"><?php echo $bus['harga'] ?></p>
                        <button class="btn btn-primary w-100" onclick="javascript: window.location = 'formTiket.php?id=<?php echo $bus['id'] ?>'">Pilih</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>