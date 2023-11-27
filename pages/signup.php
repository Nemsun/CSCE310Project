<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <style>
            * {
                font-family: 'Poppins', sans-serif;
            }

            h1 {
                font-weight: bold;
            }

            body {
                margin: 0;
                padding: 0;
                background-color: #500000;
            }
            .login-container {
                width: 500px;
                height: 460px;
                margin: 0 auto;
                margin-top: 250px;
                background-color: white;
                display: flex;
                flex-direction: column;
                text-align: center;
                border-radius: 12px;
            }

            #signup-text {
                font-size: 10px;
            }

            a {
                text-decoration: none;
                color: #0082CB;
            }

            input, text {
                border-radius: 12px;
                width: 420px;
                height: 44px;
                margin: 12px auto;
                padding: 0 10px;
            }

            button {
                width: 420px;
                height: 63px;
                background-color: #500000;
                margin: 21px auto;
                color: white;
                font-weight: bold;
                font-size: 16px;
                border: none;
                border-radius: 12px;
                cursor: pointer;
            }

        </style>
    </head>
    <body>
        <div class="login-container">
            <h1>SIGNUP</h1>
            <input type="text" placeholder="Username" id="username" name="username" required>
            <input type="password" placeholder="Create password" id="create-password" name="password" required>
            <input type="password" placeholder="Confirm password" id="confirm-password" name="password" required>
            <span id="signup-text">Already have an account? <a href="../">Login</a></span>
            <button type="submit" id="signup-button">SIGNUP</button>
        </div>
    </body>
</html>