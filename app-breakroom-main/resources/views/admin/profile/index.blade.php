@extends('admin.layout.app')

@section('title', 'Profile Settings')

@section('content')
<div class="container mx-auto p-4 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Profile Settings</h2>
                @if(auth()->user()->photo)
                    <img src="{{ Storage::url(auth()->user()->photo) }}" 
                         alt="Profile" 
                         class="h-12 w-12 rounded-full object-cover">
                @endif
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Profile Photo -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                    <input type="file" name="photo" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100">
                </div>

                <!-- Name -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" required
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" required
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Phone Number -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone_number" value="{{ auth()->user()->phone_number }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Address -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ auth()->user()->address }}</textarea>
                </div>

                <!-- Birth Date -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Birth Date</label>
                    <input type="date" name="birth_date" value="{{ auth()->user()->birth_date }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Bio -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea name="bio" rows="4"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ auth()->user()->bio }}</textarea>
                </div>

                <!-- Password Section -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>
                    
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection