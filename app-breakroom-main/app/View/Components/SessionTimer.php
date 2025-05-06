<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SessionTimer extends Component
{
    public $booking;
    public $table_id;
    public $startTime;
    public $duration;
    public $currentPrice;
    public $isPackage;

    public function __construct($booking = null, $table_id = null)
    {
        $this->booking = $booking;
        $this->table_id = $table_id;
        
        if ($booking && $booking->started_at) {
            $this->startTime = Carbon::parse($booking->started_at);
            $this->duration = $this->calculateDuration();
            $this->currentPrice = $this->calculateCurrentPrice();
            $this->isPackage = $booking->booking_type === '3-hour-package';
        }
    }

    protected function calculateDuration(): string
    {
        if (!$this->startTime) return '00:00';
        
        $duration = $this->startTime->diffInMinutes(now());
        $hours = floor($duration / 60);
        $minutes = $duration % 60;
        
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    protected function calculateCurrentPrice(): float
    {
        if (!$this->booking || !$this->startTime) return 0;

        if ($this->isPackage) {
            return $this->booking->final_price;
        }

        $duration = $this->startTime->diffInMinutes(now());
        return ($duration / 60) * $this->booking->table->price;
    }

    public function render(): View
    {
        return view('components.session-timer', [
            'duration' => $this->duration,
            'currentPrice' => $this->currentPrice,
            'isPackage' => $this->isPackage
        ]);
    }
}