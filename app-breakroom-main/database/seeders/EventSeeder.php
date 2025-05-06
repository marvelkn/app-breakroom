<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'name' => 'PETIRCINERE 10-Ball Open 2025 International Championship',
                'description' => "PETIRCINERE is hosting a 10-Ball Open Tournament, promising thrilling competition in the pool community. Players from various skill levels are invited to showcase their prowess in accordance with US 10-Ball Rules. The tournament follows a call-shot format where skill and strategy determine the winner, echoing recent intense matchups like Carlo Biado vs. Albin Ouschan and Shane Van Boening vs. Ko Pin Yi. Held in an atmosphere of sportsmanship and precision, PETIRCINERE's event promises to be a celebration of cue sports excellence, aligning with global standards seen in events such as the Maldives Open 2024.",
                'date' => now()->addDay(),
                'time' => now(),
                'location' => 'Cisadane Riverside',
                'max_participants' => 64
            ],
            [
                'name' => 'Nusantara 9-Ball Open 2025 Tournament',
                'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum, repudiandae tenetur. Magni labore quas porro ratione similique nesciunt consectetur ipsam accusantium repellendus atque maxime adipisci mollitia voluptatibus voluptatum, sed corrupti error, voluptates sapiente rerum unde voluptas aliquam odit eaque! Porro voluptate fugiat autem magni unde quibusdam ipsa laborum, exercitationem nam.",
                'date' => now(),
                'time' => now(),
                'location' => 'Universitas Multimedia Nusantara',
                'status' => 'Ongoing',
                'max_participants' => 32
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
