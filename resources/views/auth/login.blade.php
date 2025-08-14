<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DevRank</title>
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
                    Continue Your<br>
                    <span class="text-indigo-200">Learning Journey</span>
                </h2>
                
                <p class="text-lg text-indigo-100 leading-relaxed mb-8 max-w-md">
                    Access your projects, upcoming coaching sessions, booked events, 
                    and continue growing as a student developer.
                </p>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        <span>Your Projects</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <span>Coaching Sessions</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                        <span>Event Calendar</span>
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
                    <p class="text-gray-600">Welcome back, future tech leader!</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                    <p class="text-gray-600">Access your projects, coaching sessions, and upcoming events</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

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
                               autofocus 
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
                               autocomplete="current-password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200 ease-in-out hover:border-gray-400" 
                               placeholder="Enter your password">
                        @if($errors->get('password'))
                            <p class="mt-2 text-sm text-red-600">{{ implode(', ', $errors->get('password')) }}</p>
                        @endif
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember"
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded transition duration-200">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-sm text-primary hover:text-primary-dark font-medium transition duration-200">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-4 rounded-lg transition duration-200 ease-in-out transform hover:scale-[1.02] focus:ring-4 focus:ring-primary/25">
                        Access My Dashboard
                    </button>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" 
                               class="font-semibold text-primary hover:text-primary-dark transition duration-200">
                                Create one here
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Social Login Options (Optional) -->
                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-gray-50 text-gray-500">Quick actions after login</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-3 gap-3">
                        <div class="text-center p-3 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-100">
                            <div class="w-8 h-8 mx-auto mb-2 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-blue-700">Submit Project</span>
                        </div>
                        
                        <div class="text-center p-3 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border border-green-100">
                            <div class="w-8 h-8 mx-auto mb-2 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 9a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-green-700">Book Coaching</span>
                        </div>
                        
                        <div class="text-center p-3 bg-gradient-to-br from-purple-50 to-violet-50 rounded-lg border border-purple-100">
                            <div class="w-8 h-8 mx-auto mb-2 bg-purple-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 9a5 5 0 110-10 5 5 0 010 10z"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-purple-700">Join Events</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    <p class="font-medium text-gray-600">Student Developer Hub • Powered by DevRank</p>
                    <p class="mt-1">Projects • Coaching • Events • Expert Feedback</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>