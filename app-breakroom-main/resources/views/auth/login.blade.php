<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/4dad1e0fea.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('css/login.css') }}" />
    <title>Login & Register</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                {{-- Login Form --}}
                <form action="{{ route('login') }}" method="POST" class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <div class="check">
                        <input class="checkbox_input" type="checkbox" name="remember" id="remember">
                        <label class="checkbox" for="remember">Remember Me</label>
                    </div>
                    <input type="submit" value="Login" class="btn solid" />
                    <button id="goBackBtn" class="btn go-back-btn">Back to Welcome Page</button>
                    
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </form>

                {{-- Register Form --}}
                <form action="{{ route('register') }}" method="POST" class="sign-up-form">
                    @csrf
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Name" name="name" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-unlock-alt"></i>
                        <input type="password" placeholder="Confirm Password" name="password_confirmation" required />
                    </div>
                    <div class="check">
                        <input class="checkbox_input" type="checkbox" id="terms" required />
                        <label class="checkbox" for="terms">
                            I Agree to the <span class="show-btn">Terms and Conditions</span>
                        </label>
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>If you don't have an account, click the register button to sign up.</p>
                    <button class="btn transparent" id="sign-up-btn">Sign up</button>
                </div>
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us?</h3>
                    <p>If you already have an account, click the sign-in button to log in.</p>
                    <button class="btn transparent" id="sign-in-btn">Sign in</button>
                </div>
            </div>
        </div>
    </div>

    <div class="containerBg">
            <div class="containerShow">
                <label class="close-btn fas fa-times" id="closeTerms"></label>
                <div class="text">Terms and Condition</div>
                <div class="content">
                <h1>General requirements</h1>
                <ol>
                    <li>This website is an online platform created with the intent and purpose of ordering billiard tables from several billiard venues in the Jabodetabek area, our service will enable users to order billiard tables easily and quickly.</li>
                    <li>Users can log in and create an account for the sake of ordering or checking details about ordering billiard tables.</li>
                    <li>Users must be at least 17 years old to be able to book with their own account, if users are not yet 17 years old please find a trusted adult as a companion and assist in ordering.</li>
                    <li>Users are responsible for maintaining the security of their respective log-in information and are not permitted to provide any information to third parties.</li>
                    <li>This website will provide several e-wallet payment methods, please only follow the website instructions when making a transaction.</li>
                    <li>If the payment has been received, it cannot be canceled or in other words there will be no refund.</li>
                    <li>This website is made with full awareness and responsibility, any party is not permitted to imitate or distribute content on this website.</li>
                </ol>

                <h1>Privacy Policy</h1>
                <ol>
                    <li>We collect user personal information for verification and order confirmation purposes.</li>
                    <li>User's personal information will not be distributed or provided to third parties without the user's consent.</li>
                </ol>

                <h1>Limitation of Liability</h1>
                <ol>
                    <li>We are not responsible for any loss or damage arising from the use of our website services.</li>
                    <li>Users are responsible for any damage or loss caused by their own actions.</li>
                </ol>

                <h1>Service Changes and Closures</h1>
                <ol>
                    <li>We reserve the right to make changes to our service at any time without prior notification.</li>
                    <li>We also reserve the right to close our website when necessary.</li>
                </ol>

                <h1>Contact</h1>
                <ol>
                    <li>If you have questions or complaints, please contact us via email (mb_table@gmail.com) or the telephone number (+6285861821216).</li>
                </ol>
            </div>
        </div>

    <script src="{{ url('js/login.js') }}"></script>
</body>
</html>
