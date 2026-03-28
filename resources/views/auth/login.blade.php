<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TraxFit Gym</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #7c3aed;
            --primary-light: #a78bfa;
            --purple-deep: #2e1065;
        }
        
        body {
            background: linear-gradient(145deg, #0a0a0f 0%, #1a1035 50%, #2d1b4d 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Logo TRAX FIT besar di background (style dari yang pertama) */
        .background-logo {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            height: 90%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0.15;
            pointer-events: none;
            z-index: 0;
            animation: slowZoom 20s ease-in-out infinite;
        }

        @keyframes slowZoom {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.05); }
        }

        .background-logo .trax {
            font-size: min(15vw, 200px);
            font-weight: 900;
            color: white;
            letter-spacing: 20px;
            text-transform: uppercase;
            text-shadow: 0 0 50px rgba(139, 92, 246, 0.5);
            line-height: 1;
            margin-bottom: -20px;
        }

        .background-logo .fit {
            font-size: min(12vw, 160px);
            font-weight: 900;
            color: var(--primary-light);
            letter-spacing: 25px;
            text-transform: uppercase;
            text-shadow: 0 0 60px rgba(124, 58, 237, 0.6);
            line-height: 1;
        }

        .background-logo .separator {
            width: 300px;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary-light), transparent);
            margin: 20px 0;
        }

        /* Second layer logo lebih kecil untuk efek depth */
        .background-logo-2 {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-5deg);
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0.05;
            pointer-events: none;
            z-index: 0;
        }

        .background-logo-2 .trax {
            font-size: min(20vw, 300px);
            font-weight: 900;
            color: var(--primary-light);
            letter-spacing: 30px;
            text-transform: uppercase;
            line-height: 1;
        }

        .background-logo-2 .fit {
            font-size: min(16vw, 250px);
            font-weight: 900;
            color: white;
            letter-spacing: 40px;
            text-transform: uppercase;
            line-height: 1;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(167, 139, 250, 0.25);
            box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(167, 139, 250, 0.15);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 50% 50%, rgba(167, 139, 250, 0.08) 0%, transparent 60%);
            animation: rotate 30s linear infinite;
            z-index: 0;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .small-logo {
            width: 65px;
            height: 65px;
            margin: 0 auto 1rem;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 18px;
            padding: 12px;
            backdrop-filter: blur(5px);
            border: 1.5px solid rgba(167, 139, 250, 0.4);
            box-shadow: 0 8px 20px -8px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }
        
        .small-logo:hover {
            border-color: rgba(167, 139, 250, 0.8);
            box-shadow: 0 12px 25px -10px rgba(167, 139, 250, 0.3);
        }
        
        .small-logo-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.5));
            opacity: 0.95;
        }
        
        .gym-name {
            font-size: 1.6rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.95);
            text-align: center;
            margin-bottom: 1.8rem;
            letter-spacing: -0.3px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 2;
            font-weight: 500;
        }
        
        .gym-name span {
            color: var(--primary-light);
            font-weight: 700;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1rem;
            z-index: 2;
        }
        
        .input-field {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
            background: rgba(0, 0, 0, 0.3);
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            transition: all 0.3s;
            backdrop-filter: blur(5px);
        }
        
        .input-field:focus {
            outline: none;
            border-color: rgba(167, 139, 250, 0.5);
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.1);
        }
        
        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.35);
            font-weight: 300;
            font-size: 0.9rem;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(167, 139, 250, 0.6);
            font-size: 0.95rem;
            z-index: 3;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(167, 139, 250, 0.5);
            cursor: pointer;
            transition: all 0.3s;
            background: transparent;
            border: none;
            z-index: 3;
            font-size: 0.9rem;
        }
        
        .password-toggle:hover {
            color: rgba(167, 139, 250, 0.9);
        }
        
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin: 1.25rem 0 1.5rem;
            z-index: 2;
            position: relative;
        }
        
        .checkbox-custom {
            width: 1.1rem;
            height: 1.1rem;
            border: 1.5px solid rgba(167, 139, 250, 0.4);
            border-radius: 0.3rem;
            background: rgba(0, 0, 0, 0.3);
            cursor: pointer;
            appearance: none;
            position: relative;
            transition: all 0.2s;
        }
        
        .checkbox-custom:checked {
            background: rgba(124, 58, 237, 0.6);
            border-color: rgba(167, 139, 250, 0.8);
        }
        
        .checkbox-custom:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.6rem;
        }
        
        .checkbox-label {
            margin-left: 0.6rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            font-weight: 300;
            letter-spacing: 0.3px;
        }
        
        .gradient-button {
            width: 100%;
            background: linear-gradient(145deg, rgba(124, 58, 237, 0.8), rgba(167, 139, 250, 0.8));
            background-size: 200% auto;
            color: white;
            font-weight: 500;
            padding: 0.9rem;
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 1px;
            font-size: 0.9rem;
            backdrop-filter: blur(5px);
            z-index: 2;
        }
        
        .gradient-button:hover {
            background: linear-gradient(145deg, rgba(124, 58, 237, 0.9), rgba(167, 139, 250, 0.9));
            border-color: rgba(167, 139, 250, 0.4);
            box-shadow: 0 8px 20px -8px rgba(124, 58, 237, 0.4);
        }
        
        .footer {
            margin-top: 1.8rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.7rem;
            position: relative;
            z-index: 2;
            font-weight: 300;
            letter-spacing: 1px;
        }

        .card-content {
            position: relative;
            z-index: 2;
        }

        /* Decorative line */
        .decor-line {
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(167, 139, 250, 0.3), transparent);
            margin: 1.8rem 0 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .background-logo .trax {
                letter-spacing: 10px;
                font-size: 15vw;
            }
            .background-logo .fit {
                letter-spacing: 15px;
                font-size: 12vw;
            }
            .background-logo .separator {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Logo TRAX FIT besar di background (style keren dari yang pertama) -->
    <div class="background-logo">
        <div class="trax">TRAX</div>
        <div class="separator"></div>
        <div class="fit">FIT</div>
    </div>

    <!-- Second layer untuk efek depth -->
    <div class="background-logo-2">
        <div class="trax">TRAX</div>
        <div class="fit">FIT</div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 relative">
        <div class="login-card w-full max-w-sm rounded-2xl p-6">
            <div class="card-content">
                <!-- Small Logo -->
                <div class="small-logo">
                    <img src="{{ asset('images/logo/TRAX.png') }}" 
                         alt="TraxFit Gym" 
                         class="small-logo-image"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/65/7c3aed/ffffff?text=TRAX';">
                </div>
                
                <h1 class="gym-name">
                    <span>TraxFit</span> Gym
                </h1>

                @if($errors->any())
                    <div class="mb-4 bg-purple-900/20 border-l-4 border-purple-400/50 rounded-lg p-3 backdrop-blur-sm">
                        <p class="text-purple-200/90 text-sm">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Username -->
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               required
                               class="input-field"
                               placeholder="Username"
                               value="{{ old('username') }}">
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required
                               class="input-field"
                               placeholder="Password">
                        <button type="button" 
                                onclick="togglePassword()" 
                                class="password-toggle focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- Remember Me -->
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="remember" id="remember" class="checkbox-custom">
                        <label for="remember" class="checkbox-label">Ingat Saya</label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="gradient-button">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        MASUK
                    </button>
                </form>

                <!-- Decorative line -->
                <div class="decor-line"></div>

                <!-- Footer -->
                <div class="footer">
                    © 2024 TraxFit Gym
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('#password ~ .password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto-focus username
        document.getElementById('username').focus();
    </script>
</body>
</html>