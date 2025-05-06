

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Verify Your Email</h2>

        @if (session('success'))
            <p class="text-green-500 text-center mb-4">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <p class="text-red-500 text-center mb-4">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('otp.verify.post') }}">
            @csrf
            <label class="block mb-2 font-semibold">Enter OTP</label>
            <input type="text" name="otp" required 
                   class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:border-blue-500 border border-gray-600 mb-4">
            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 py-2 rounded-lg text-white font-semibold">
                Verify OTP
            </button>
        </form>
        <div class="mt-4 text-center">
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="text-blue-500 hover:underline">
                        Resend verification code
                    </button>
                </form>
            </div>
    </div>
</body>
</html>
