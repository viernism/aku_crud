<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/login.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Login</title>
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

    
</body>
</html>
