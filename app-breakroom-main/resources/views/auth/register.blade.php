<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Breakroom</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-gray-800 rounded-lg shadow-lg p-8">
            <a href="/" class="text-white hover:text-gray-300 mb-6 inline-block">← Back to Home</a>
            <h2 class="text-3xl font-bold text-center text-white mb-8">Create Account</h2>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="name">Name</label>
                    <input type="text" name="name" id="name" required 
                           class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email" required 
                           class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="password">Password</label>
                    <input type="password" name="password" id="password" required 
                           class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                           class="w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">
                    Register
                </button>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-400">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Login here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>