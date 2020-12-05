<!doctype html>

<head>
    <title> Testing Ground </title>
    <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/1488/1488158.svg">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <?php
    include('functions/jwt/env.php');
    include('functions/api/main.php');

    $redirect_url = "http://localhost/zoom-api-php/index.php";

    if (isset($_GET['code'])) {
        $code = $_GET['code'];

        try {
            $response = get_token($client_id, $secret_key, $code, $redirect_url);
        } catch (Exception $e) {
            $response = json_encode(
                array(
                    "error" => $e->getMessage()
                )
            );
        }
        if (isset(json_decode($response, true)['access_token'])) {
            $token = json_decode($response, true)['access_token'];
            $refresh_token = json_decode($response, true)['refresh_token'];
        } else {
            $token = null;
            $refresh_token = null;
        }

        if ($token && $refresh_token)
            echo "<div id='token' style='text-align: center; margin: auto; color: blue;'>" . $token . "</div><br><div id='refresh_token' style='text-align: center; margin: auto; color: red;'>" . $refresh_token . "</div>";
        else
            echo "<a href='https://zoom.us/oauth/authorize?response_type=code&client_id=nMrrmpxITEGF9ld0OkWN2w&redirect_uri=$redirect_url' style='width:200px; height:200px; position: fixed; top: 50%; left: 50%; margin-top: -100px; margin-left: -100px;'><button class='btn btn-success'>Login Zoom</button></a>";
    } else {
        echo "<a href='https://zoom.us/oauth/authorize?response_type=code&client_id=nMrrmpxITEGF9ld0OkWN2w&redirect_uri=$redirect_url' style='width:200px; height:200px; position: fixed; top: 50%; left: 50%; margin-top: -100px; margin-left: -100px;'><button class='btn btn-success'>Login Zoom</button></a>";
    }

    function get_token($client_id, $secret_key, $code, $redirect_url)
    {
        $url = "https://zoom.us/oauth/token?grant_type=authorization_code&code=$code&redirect_uri=$redirect_url";
        $headers = array(
            "Authorization: Basic " . base64_encode($client_id . ':' . $secret_key)
        );
        $result = requestAPI('POST', $url, $headers, null);
        return $result;
    }
    ?>
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
    if (document.getElementById("token") && document.getElementById("refresh_token")) {
        // eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiIxMzZjOGM5My00NDZiLTQ2MWMtODIyOS1lMmNiZGI5NmM2MDcifQ.eyJ2ZXIiOjcsImF1aWQiOiI1ODljM2YyOTRiM2JlOGM2ZDc5ZjQ3OTIyZWNhN2Y4OSIsImNvZGUiOiJSeTg5NGV1TFduX2Z1ODNJeEhUUzF5ZXhTbC1sdG1sVVEiLCJpc3MiOiJ6bTpjaWQ6bk1ycm1weElURUdGOWxkME9rV04ydyIsImdubyI6MCwidHlwZSI6MCwidGlkIjowLCJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJmdTgzSXhIVFMxeWV4U2wtbHRtbFVRIiwibmJmIjoxNjA3MjA0NjI2LCJleHAiOjE2MDcyMDgyMjYsImlhdCI6MTYwNzIwNDYyNiwiYWlkIjoiVVJTTWNwRzJRZ1NlZHhRTl9rYVJsUSIsImp0aSI6IjU1ZmY4NjBhLWY1ZjUtNDAyYS1iMjNiLTIxMDZkYzU1NTJmMSJ9.GOPDIbTRlcSChDk-J1WrIp2ULleMXxbeQ-cZ214EzRLwORerDCSsKZw6CP14J2fmjZLIoHVro7efuFIZrhnYVQ
        const token = document.getElementById("token").innerHTML;
        // eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiI0Yzg4MGNmNi00Y2I4LTQxNjAtYjAxMy0yZDcyNzk3NmUxMDAifQ.eyJ2ZXIiOjcsImF1aWQiOiI1ODljM2YyOTRiM2JlOGM2ZDc5ZjQ3OTIyZWNhN2Y4OSIsImNvZGUiOiJSeTg5NGV1TFduX2Z1ODNJeEhUUzF5ZXhTbC1sdG1sVVEiLCJpc3MiOiJ6bTpjaWQ6bk1ycm1weElURUdGOWxkME9rV04ydyIsImdubyI6MCwidHlwZSI6MSwidGlkIjowLCJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJmdTgzSXhIVFMxeWV4U2wtbHRtbFVRIiwibmJmIjoxNjA3MjA0NjI2LCJleHAiOjIwODAyNDQ2MjYsImlhdCI6MTYwNzIwNDYyNiwiYWlkIjoiVVJTTWNwRzJRZ1NlZHhRTl9rYVJsUSIsImp0aSI6IjBjMmFmNTUxLTI4N2YtNGY2OS1hYjc1LTlkODA4YzkyNjFjMyJ9.4nts_n2XuQ1L3jDAhg0JnxDL3BtKpGG9cxlI-E8cpuSmfG7kQ6sTHiDy55jKtImvBMROJ2o--V2ht0jvpBstyw
        const refresh_token = document.getElementById("refresh_token").innerHTML;

        const topic = "Testing";
        const start_time = "2020-12-06T01:00:00";
        const duration = 60;
        const password = "";
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        $.ajax({
            type: "POST",
            url: "functions/zoom/main.php",
            data: `token=${token}&refresh_token=${refresh_token}&topic=${topic}&start_time=${start_time}&duration=${duration}&password=${password}&timezone=${timezone}`,
            cache: false,
            success: function(response) {
                const result = response;
                Swal.fire({
                    title: 'ZOOM',
                    text: result,
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
    }
</script>