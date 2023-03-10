<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/login.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>a fucking login site</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Login</h1>
        <form action="/login" method="post">
            @csrf
            <div class="form-group">
                <label for="email">Email</label><br>
                <input type="email" name="email" value="{{ old('email') }}"><br>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror<br>
            </div>
            <div class="form-group">
                <label>Password</label><br>
                <input type="password" name="password" value="{{ old('password') }}"><br>
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror<br>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <p class="mt-3">Don't have an account? <a href="/register" class="test">Register Here!</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
