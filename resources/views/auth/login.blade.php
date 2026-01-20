<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Reservasi Hotel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #e7c506 0%, #000000 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Animated gradient background */
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
        }
        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
        }
        
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeInDown 1.1s cubic-bezier(.68,-0.55,.27,1.55);
            transition: box-shadow 0.4s, transform 0.4s;
        }
        
        .login-card:hover {
            box-shadow: 0 16px 48px #FFD70055, 0 2px 8px #764ba244;
            transform: scale(1.025) rotate(-1deg);
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-40px);}
            to { opacity: 1; transform: translateY(0);}
        }
        
        .login-header {
            background: linear-gradient(135deg, #000000 0%, #dcab09 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header .login-icon {
            font-size: 54px;
            margin-bottom: 15px;
            display: inline-block;
            /* Multiple animations: popIn, spin, float, glowPulse */
            animation: popIn 1.2s cubic-bezier(.68,-0.55,.27,1.55), 
                       hotelSpin 8s linear infinite, 
                       hotelFloat 3s ease-in-out infinite alternate,
                       glowPulse 2.5s ease-in-out infinite alternate;
            filter: drop-shadow(0 0 12px rgba(224, 143, 143, 0.47));
            transition: transform 0.3s;
        }
        
        .login-header .login-icon:hover {
            animation: bounce 0.7s, 
                       hotelSpin 8s linear infinite, 
                       hotelFloat 3s ease-in-out infinite alternate,
                       glowPulse 2.5s ease-in-out infinite alternate;
            transform: scale(1.15) rotate(-10deg);
        }
        
        @keyframes popIn {
            0% { opacity: 0; transform: scale(0.7);}
            80% { opacity: 1; transform: scale(1.08);}
            100% { opacity: 1; transform: scale(1);}
        }
        @keyframes hotelSpin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
        @keyframes hotelFloat {
            0% { transform: translateY(0);}
            100% { transform: translateY(-16px);}
        }
        @keyframes glowPulse {
            0% { text-shadow: 0 0 16px #FFD70088, 0 0 32px #fff3, 0 0 32px #FFD700, 0 0 64px #FFD70044;}
            100% { text-shadow: 0 0 32px #FFD700cc, 0 0 64px #fff7, 0 0 64px #FFD700, 0 0 128px #FFD70088;}
        }
        @keyframes bounce {
            0%   { transform: scale(1) translateY(0);}
            30%  { transform: scale(1.2, 0.8) translateY(-10px);}
            50%  { transform: scale(0.95, 1.05) translateY(0);}
            70%  { transform: scale(1.05, 0.95) translateY(-5px);}
            100% { transform: scale(1) translateY(0);}
        }
        
        .login-header .login-icon-glow {
            color: #FFD700;
            /* text-shadow handled by glowPulse animation */
        }
        
        .login-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 28px;
            letter-spacing: 1px;
        }
        
        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .login-body {
            padding: 40px;
            animation: fadeIn 1.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0;}
            to { opacity: 1;}
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #deab06;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .form-label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #FFD700 0%, #764ba2 100%);
            border: none;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
            width: 100%;
            color: white;
            box-shadow: 0 2px 8px #FFD70033;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: "";
            position: absolute;
            left: -75%;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, rgba(255,215,0,0.15), rgba(255,255,255,0.05));
            transform: skewX(-20deg);
            transition: left 0.5s;
            z-index: 0;
        }
        
        .btn-login:hover::before {
            left: 120%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 10px 20px #FFD70099, 0 0 16px #764ba244;
            color: #232526;
            background: linear-gradient(135deg, #764ba2 0%, #FFD700 100%);
        }
        
        .show-password-btn {
            border: none;
            background: none;
            color: #764ba2;
            font-size: 1.1em;
            cursor: pointer;
            padding: 0 8px;
            transition: color 0.2s;
        }
        
        .show-password-btn:hover {
            color: #FFD700;
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }
        
        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            margin-top: 20px;
        }
        
        .register-link p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        
        .register-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }
        
        .input-group-text {
            background: white;
            border: 2px solid #e0e0e0;
            color: #667eea;
        }
        
        .input-group .form-control:focus ~ .input-group-text {
            border-color: #667eea;
        }
        
        /* Animated border on focus */
        .form-control:focus, .input-group:focus-within {
            box-shadow: 0 0 0 2px #FFD70055;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-icon login-icon-glow">
                    <i class="fas fa-hotel"></i>
                </div>
                <h2>Hotel Reservation</h2>
                <p>Sistem Manajemen Reservasi Hotel</p>
            </div>
            
            <!-- Body -->
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Login Gagal!</strong>
                        <div>{{ $errors->first('email') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('authenticate') }}" method="POST" autocomplete="off">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Masukkan email Anda" required autofocus>
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Masukkan password Anda" required>
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <button type="button" class="show-password-btn" tabindex="-1" onclick="togglePassword()">
                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Button Login -->
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>

                    <!-- Forgot Password -->
                    <div class="forgot-password">
                        <a href="#">Lupa password?</a>
                    </div>
                </form>

                <!-- Register Link -->
                <div class="register-link">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4">
            <small class="text-white" style="opacity: 0.8;">
                &copy; 2026 Hotel Reservation System. Semua hak dilindungi.
            </small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/hide password
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
