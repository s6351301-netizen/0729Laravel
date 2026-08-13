<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .box {
            width: 100%;
            height: 30vh;
            background-color: lightblue;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                {{-- 網址改變 --}}
                {{-- <a href="http://localhost/f1"> --}}
                <a href="<?= route('hotel.f1') ?>">
                    <div class="box">
                        1F
                    </div>
                </a>

            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                {{-- <a href="http://localhost/f2"> --}}
                <a href="<?= route('hotel.f2') ?>">
                    <div class="box">
                        2F
                    </div>
                </a>

            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                {{-- <a href="http://localhost/f3"> --}}
                <a href="<?= route('hotel.f3') ?>">
                    <div class="box">
                        3F
                    </div>
                </a>

            </div>
        </div>
    </div>


</body>

</html>
