<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Sum Table</h2>
        <p>The .table class adds basic styling (light padding and horizontal dividers) to a table:</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Num1</th>
                    <th>Num2</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $data['num1']; ?></td>
                    <td><?= $data['num2']; ?></td>
                    <td><?= $data['result']; ?></td>
                </tr>
                <?php 
                    // dd($data);
                ?>

                {{-- <tr>
                    <td>1000</td>
                    <td>500</td>
                    <td>1500</td>
                </tr> --}}

                
            </tbody>
        </table>
    </div>

</body>

</html>
