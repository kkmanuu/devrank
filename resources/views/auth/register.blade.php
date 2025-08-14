<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DevRank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#6366f1',
                        'primary-dark': '#4f46e5',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-inter bg-gray-50 min-h-screen">
    <div class="min-h-screen flex">
        <!-- Left Side - Image & Welcome -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary to-primary-dark relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <img src="{{ asset('images/techss.jpg') }}" alt="DevRank" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay">
            
            <div class="relative z-10 flex flex-col justify-center items-start p-12 text-white">
                <div class="mb-8">
                    <h1 class="text-5xl font-bold mb-4">DevRank</h1>
                    <div class="w-20 h-1 bg-white/80 rounded-full"></div>
                </div>
                
                <h2 class="text-3xl font-semibold mb-6 leading-tight">
                    Launch Your Tech Career<br>
                    <span class="text-indigo-200">with DevRank</span>
                </h2>
                
                <p class="text-lg text-indigo-100 leading-relaxed mb-8 max-w-md">
                    Join a community of student developers to build projects, gain expert feedback, 
                    and grow with personalized coaching.
                </p>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        <span>Submit Projects</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <span>Book Coaching</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                        <span>Join Events</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-pink-400 rounded-full"></div>
                        <span>Expert Feedback</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">DevRank</h1>
                    <p class="text-gray-600">Launch your tech career as a student developer</p>
                </div>

                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Join DevRank</h2>
                    <p class="text-gray-600">Start building projects, booking coaching, and growing your skills</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name
                        </label>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200 ease-in-out hover:border-gray-400" 
                               placeholder="Enter your full name">
                        @if($errors->get('name'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(', ', $errors->get('name')) }}</p>
                        @endif
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200 ease-in-out hover:border-gray-400" 
                               placeholder="Enter your email">
                        @if($errors->get('email'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(', ', $errors->get('email')) }}</p>
                        @endif
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200 ease-in-out hover:border-gray-400" 
                               placeholder="Create a strong password">
                        @if($errors->get('password'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(', ', $errors->get('password')) }}</p>
                        @endif
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200 ease-in-out hover:border-gray-400" 
                               placeholder="Confirm your password">
                        @if($errors->get('password_confirmation'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(', ', $errors->get('password_confirmation')) }}</p>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-4 rounded-lg transition duration-200 ease-in-out transform hover:scale-[1.02] focus:ring-4 focus:ring-primary/25">
                        Start Your Journey
                    </button>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" 
                               class="font-semibold text-primary hover:text-primary-dark transition duration-200">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>By joining DevRank, you agree to our Terms of Service and Privacy Policy</p>
                    <p class="mt-2 font-medium text-gray-600">Ready to submit projects • Book coaching • Join events</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>