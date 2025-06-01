<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-png" href="{{ asset('Logo Enerzero.png') }}" />
    <title>Register | Enerzero</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 98vh;
            background-image: url("{{ asset('BackGround.png') }}");
            background-size: cover;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            display: flex;
            width: 80%;
            max-width: 900px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .left, .right {
            flex: 1;
            padding: 40px;
        }
        .left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #e0ffe0;
            border-radius: 15px 0 0 15px;
        }
        .right {
            border-left: 1px solid #ddd;
        }
        h1 {
            margin-bottom: 10px;
            font-weight: 700;
        }
        label {
            margin-top: 15px;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            font-size: 16px;
        }
        button {
            background-color: #f5c200;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            font-size: 18px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
        }
        .image-normal {
            transition: transform 0.5s ease;
        }
        .slide-right {
            transform: translateX(100%);
        }
    </style>
</head>
<body>

<div class="container">
    <div id="image-container" class="image-normal left">
        <img src="{{ asset('Logo icon.png')}}" alt="Solar Panel" style="width: 70%;">
        <img src="{{ asset('LoginBG.png')}}" alt="Solar Panel" style="width: 100%;">
        <h1>Save Energy, Save the world!</h1>
    </div>
    <div class="right">
        <h1>Hello, New User!</h1>
        <p>Small energy changes, massive global impact. With Enerzero, transforming how the world uses power!</p>
        <form action="{{ route('regist') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <div class="footer">
            <p>Already have an account? <a href="{{ route('login') }}" id="go-login">Login</a></p>
        </div>
    </div>
</div>
<script>
    const btnLogin = document.getElementById('go-login');
    const imageContainer = document.getElementById('image-container');

    btnLogin.addEventListener('click', function(event) {
        event.preventDefault();
        imageContainer.classList.add('slide-right');
        setTimeout(() => {
            window.location.href = "{{ route('login') }}";
        }, 500); // waktu animasi 0.5 detik
    });
</script>

</body>
</html>