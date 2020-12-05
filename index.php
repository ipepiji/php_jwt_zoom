<!doctype html>

<head>
    <title> Testing Ground </title>
    <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/1488/1488158.svg">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>

</body>

</html>

<!-- include jquery -->
<script src=" https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
</script>
<!-- include sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- include moment -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script>
    const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IjU4WEpBdGpfUkRLWnVManR3TmdvSVEiLCJleHAiOjE2MDcwOTYwNDksImlhdCI6MTYwNzA5MDY1MH0.5k2flLEa-DvlDGJFZDhgw1RpixyqcA15gCIFoG4xK0k";
    const current = moment().unix();
    $.ajax({
        type: "POST",
        url: "functions/zoom/main.php",
        data: `token=${token}&current=${current}`,
        cache: false,
        success: function(response) {
            const result = JSON.parse(response);
            Swal.fire({
                title: 'ZOOM',
                text: JSON.stringify(result),
                showCancelButton: false,
                showConfirmButton: false,
                width: 600,
                padding: '3em',
                background: '#fff url(https://sweetalert2.github.io/images/trees.png)',
                backdrop: `
                    rgba(0,0,123,0.4)
                    url("https://sweetalert2.github.io/images/nyan-cat.gif")
                    center top
                    no-repeat
                `
            });
        },
        failure: function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!'
            })
        }
    });
</script>