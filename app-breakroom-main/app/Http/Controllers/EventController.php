<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        // Get all events, sorted by newest to oldest date
        $events = Event::whereDate('date', '>=', now())
        ->orderBy('date', 'asc')
        ->get();

        // Ensure image URLs are properly generated
        foreach ($events as $event) {
            $event->image_url = $event->image ? Storage::url($event->image) : null;
        }

        return view('user.events.index', compact('events'));
    }

    

    public function details($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();
        $isRegistered = $event->eventRegistration()
        ->where('user_id', $user->id)
        ->where('status', 'Ready')
        ->exists();

        return view('user.events.details', compact('event', 'isRegistered'));
    }

    public function adminIndex()
    {
        $events = Event::orderBy('date', 'asc')->get();
        foreach ($events as $event) {
            $event->image_url = Storage::url($event->image);
        }
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|string', 
            'location' => 'required|string', 
            'max_participants' => 'nullable|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        $path = $request->file(key: 'image')->storePublicly('photos', 'public');
        $ext = $request->file('image')->extension();
        $validatedData['image'] = $path;
        $event = Event::create($validatedData);

        // return redirect()->route('events.index')
        //     ->with('success', 'Event berhasil dibuat');
        return redirect()->route('admin.event.adminIndex')
        ->with('success', 'Event berhasil dibuat');

    }
    public function show($id)
    {
        //
        $event = Event::with(['eventRegistration.user'])->findOrFail($id);
        $image = Storage::url($event->image);
        return view('admin.event.show', [
            'event' => $event,
            'image' => $image
        ]);
    }

    public function edit($id)
    {
        //
        $event = Event::findOrFail($id);
        $image = Storage::url($event->image);
        return view('admin.event.edit', ['event' => $event, 'image' => $image]);
    }

    public function changeImage($id)
    {
        //
        $event = Event::findOrFail($id);
        $image = Storage::url($event->image);
        return view('admin.event.change_image', ['event' => $event, 'image' => $image]);
    }

    public function update(Request $request, $id)
    {
        //
        $event = Event::findOrFail($id);
        $event->name = $request->name;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->location = $request->location;
        $event->max_participants = $request->max_participants;
        $event->save();

        return redirect('/admin/events')->with('success', 'Event updated successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->status = $request->input('status');
        $event->save();
    
        return redirect('/admin/events')->with('success', 'Table updated successfully!');
    }

    public function updateImage(Request $request, $id){
        $event = Event::findOrFail($id);
        $path = $request->file('image')->storePublicly('photos', 'public');
        $ext = $request->file('image')->extension();
        $event->image = $path;
        $event->save();
        return redirect('/admin/events')->with('success', 'Event updated successfully!');
    }

    public function register(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = auth()->user();
        
        $readyParticipantsCount = $event->eventRegistration()
            ->where('status', 'Ready')
            ->count();

        // Check if event is full (only counting ready participants)
        if ($readyParticipantsCount >= $event->max_participants) {
            return back()->with('error', 'Event sudah penuh.');
        }
        
        $registration = $event->eventRegistration()
            ->where('user_id', $user->id)
            ->first();

        if ($registration) {
            if ($registration->status === 'Ready') {
                return back()->with('error', 'Anda sudah terdaftar di event ini.');
            } elseif ($registration->status === 'Cancelled') {
                // Check again if event is full before reactivating
                if ($readyParticipantsCount >= $event->max_participants) {
                    return back()->with('error', 'Maaf, event sudah penuh.');
                }
                
                $registration->update(['status' => 'Ready']);
                return back()->with('success', 'Registrasi Anda berhasil.');
            }
        }

        // If no existing registration and event not full, create new registration
        $event->eventRegistration()->create([
            'user_id' => $user->id,
            'status' => 'Ready', 
        ]);

        return back()->with('success', 'Registrasi event berhasil');
    }

    public function cancel($eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = auth()->user();

        $registration = $event->eventRegistration()
            ->where('user_id', $user->id)
            ->where('status', 'Ready')
            ->first();

        if ($registration) {
            $registration->update(['status' => 'Cancelled']);
            return back()->with('success', 'Registrasi Anda telah dibatalkan.');
        }

        return back()->with('error', 'Anda belum terdaftar di event ini.');
    }

    public function destroy($id)
    {
        //
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect('/admin/events');
    }
}
?>