@extends('layouts.app')
<title>Event Details - Breakroom</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="relative group">
        <div
            class="absolute max-w-3xl mx-auto inset-0 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl opacity-50 transition-opacity -rotate-1">
        </div>
        <div class="max-w-3xl mx-auto bg-gray-800/90 backdrop-blur rounded-xl rounded-lg shadow-md p-6 relative opacity-100">
            <a href="{{route('dashboard')}}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 rounded-md font-semibold text-sm bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200 mb-2">
                Back to Dashboard
            </a>
            <h2 class="text-yellow-400 text-2xl font-semibold mb-2">
            <i class="fas fa-award"></i></i> Loyalty Program</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <p class="text-lg-600 mb-1">You have:</p>
            <div class="text-center">
                <h1 class="text-yellow-400" style="font-size: 100px">{{$user->loyalty_points}}</h1>
            </div>
            <p class="text-lg-600 text-end mb-2">Loyalty Points</p>

            <hr class="border-gray-300"/>

            <h2 class="text-yellow-400 text-3xl text-center font-bold mb-6">Rewards</h2>

            <!-- User's Current Vouchers -->
            <div class="mt-12">
                <h2 class="text-yellow-400 text-xl font-bold mb-4">Your Vouchers</h2>

                <div class="space-y-4">
                    @forelse ($userVouchers as $userVoucher)
                        <div class="bg-gray-50 rounded-lg p-4 shadow-sm flex justify-between items-center">
                            <div>
                                <h3 class="font-medium text-gray-800">{{ $userVoucher->voucher->name }}</h3>
                                <p class="text-sm text-gray-600">Expires: {{ $userVoucher->expires_at->format('d M Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($userVoucher->is_used)
                                        bg-gray-100 text-gray-800
                                    @else
                                        bg-green-100 text-green-800
                                    @endif
                                ">
                                    {{ $userVoucher->is_used ? 'Used' : 'Available' }}
                                </span>
                                @if(!$userVoucher->is_used)
                                    <p class="text-sm text-gray-500 mt-1">Code: {{ $userVoucher->code }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-gray-500 bg-gray-50 rounded-lg">
                            <p>You don't have any vouchers yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <hr class="mt-2" />

            <!-- Available Vouchers -->
            <h2 class="text-yellow-400 text-2xl font-bold mb-6">Vouchers</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                @forelse ($vouchers as $voucher)
                    <div class="bg-gray-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $voucher->name }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $voucher->description }}</p>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ number_format($voucher->points_required) }} points
                            </span>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Valid for {{ $voucher->validity_days }} days after redemption
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                @if($voucher->discount_type === 'percentage')
                                    {{ $voucher->discount_value }}% discount
                                @else
                                    Rp {{ number_format($voucher->discount_value, 0, ',', '.') }} off
                                @endif
                            </div>

                            @if($voucher->min_purchase)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Min. purchase: Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>

                        <div class="mt-6">
                            <form action="{{ route('user.loyalty.redeem-voucher', $voucher->id) }}" method="POST">
                                @csrf
                                <button type="submit" @if($user->loyalty_points < $voucher->points_required) disabled @endif
                                    class="w-full px-4 py-2 text-sm font-medium rounded-md 
                                    @if($user->loyalty_points >= $voucher->points_required)
                                        bg-blue-600 text-white hover:bg-blue-700
                                    @else
                                        bg-gray-300 text-gray-500 cursor-not-allowed
                                    @endif
                                    transition-colors duration-200">
                                    @if($user->loyalty_points >= $voucher->points_required)
                                        Redeem Voucher
                                    @else
                                        Not Enough Points
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-4 text-lg">No vouchers available at the moment</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection