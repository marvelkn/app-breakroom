@extends('admin.layout.app')

@section('title', 'Create New Account')

@section('content')

<div class="create-account-container w-75 mb-3" style="margin: auto; background-color:rgb(173, 116, 225); padding: 20px; border-radius: 10px">
    <h1 class="text-center">Create Account</h1>
    <form class="form" action="/admin/users/create_account" method="post" enctype="multipart/form-data">
        @csrf
        <label for="name" class="form-label">Name</label> 
        <input class="form-control" type="text" name="name" id="name" value="" required><br />
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <label for="email" class="form-label">Email</label>
        <input class="form-control" name="email" id="email" value="" required><br>
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <label for="role" class="form-label">Role</label> 
        <select name="role" id="role" class="form-select" required>
            <option value="1">Admin</option>
            <option value="2">User</option>
        </select>
        <br>

        <label for="password" class="form-label">Password</label> 
        <input class="form-control" type="password" name="password" id="password" value="" required><br />
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <label for="password_confirmation" class="form-label">Confirm Password</label> 
        <input class="form-control" type="password" name="password_confirmation" id="password_confirmations" value="" required><br />
        
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
    <a href="/admin/users" class="btn btn-info mt-3">Back to Users List</a>
</div>

@endsection