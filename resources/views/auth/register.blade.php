<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/register.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>a register site you dumbass</title>
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1 class="text-center mb-4">Register</h1>
        <form>
            <div class="mb-3">
                <label for="username" class="form label">Username</label>
                <input type="text" class="form control" id="username">
            </div>
            <div class="mb-3">
                <label for="email" class="form label">Email</label>
                <input type="email" class="form control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form label">Password</label>
                <input type="password" class="form control" id="password">
            </div>
            <button class="btn btn-primary mb-3">Register</button>
            <p>Already a user? <a href="/login" class="text-center test">LOGIN</a></p>
        </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
