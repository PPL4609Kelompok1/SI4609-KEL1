<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Enerzero</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0fff4;
            font-family: 'Roboto', sans-serif;
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
    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <h1>Save Energy, Save the world!</h1>
        <img src="path_to_image" alt="Solar Panel" style="width: 100%;">
    </div>
    <div class="right">
        <h1>Welcome Back!</h1>
        <p>Small energy changes, massive global impact. With Enerzero, transforming how the world uses power!</p>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <a href="#">Forgot Password?</a>
            <button type="submit">LOGIN</button>
        </form>
        <div class="footer">
            <p>Don’t have an account yet? <a href="{{ route('register') }}">Register</a></p>
        </div>
    </div>
</div>

</body>
</html>