<!-- resources/views/components/session-timer.blade.php -->
@if($booking && $booking->status === 'active' && $startTime)
<div class="p-4 bg-gray-900/50 border-t border-gray-700" id="timer-{{ $table_id }}">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-400">Current Session</p>
            <p class="text-lg font-semibold text-yellow-400" id="duration-{{ $booking->id }}">
                {{ $duration }}
            </p>
        </div>
        <div>
            <p class="text-sm text-gray-400">Current Price</p>
            <p class="text-lg font-semibold text-yellow-400" id="price-{{ $booking->id }}">
                Rp {{ number_format($currentPrice, 0, ',', '.') }}
            </p>
        </div>
        @if($isPackage)
            <div class="text-sm text-yellow-400 ml-2">
                (3-Hour Package)
            </div>
        @endif
    </div>
</div>
@endif