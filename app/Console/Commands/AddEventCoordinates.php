<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;

class AddEventCoordinates extends Command
{
    protected $signature = 'events:add-coordinates';
    protected $description = 'Add geographic coordinates to events based on their city';

    // Coordinate database for Italian cities
    private $cityCoordinates = [
        'Roma' => ['lat' => 41.9028, 'lng' => 12.4964],
        'Milano' => ['lat' => 45.4642, 'lng' => 9.1900],
        'Napoli' => ['lat' => 40.8518, 'lng' => 14.2681],
        'Torino' => ['lat' => 45.0703, 'lng' => 7.6869],
        'Palermo' => ['lat' => 38.1157, 'lng' => 13.3615],
        'Genova' => ['lat' => 44.4056, 'lng' => 8.9463],
        'Bologna' => ['lat' => 44.4949, 'lng' => 11.3426],
        'Firenze' => ['lat' => 43.7696, 'lng' => 11.2558],
        'Bari' => ['lat' => 41.1171, 'lng' => 16.8719],
        'Catania' => ['lat' => 37.5079, 'lng' => 15.0830],
        'Venezia' => ['lat' => 45.4408, 'lng' => 12.3155],
        'Verona' => ['lat' => 45.4384, 'lng' => 10.9916],
        'Messina' => ['lat' => 38.1938, 'lng' => 15.5540],
        'Padova' => ['lat' => 45.4064, 'lng' => 11.8768],
        'Trieste' => ['lat' => 45.6495, 'lng' => 13.7768],
        'Brescia' => ['lat' => 45.5416, 'lng' => 10.2118],
        'Parma' => ['lat' => 44.8015, 'lng' => 10.3279],
        'Prato' => ['lat' => 43.8777, 'lng' => 11.1020],
        'Modena' => ['lat' => 44.6471, 'lng' => 10.9252],
        'Reggio Calabria' => ['lat' => 38.1113, 'lng' => 15.6619],
        'Reggio Emilia' => ['lat' => 44.6989, 'lng' => 10.6297],
        'Perugia' => ['lat' => 43.1107, 'lng' => 12.3908],
        'Livorno' => ['lat' => 43.5485, 'lng' => 10.3106],
        'Ravenna' => ['lat' => 44.4184, 'lng' => 12.2035],
        'Cagliari' => ['lat' => 39.2238, 'lng' => 9.1217],
        'Foggia' => ['lat' => 41.4621, 'lng' => 15.5444],
        'Rimini' => ['lat' => 44.0678, 'lng' => 12.5695],
        'Salerno' => ['lat' => 40.6824, 'lng' => 14.7681],
        'Ferrara' => ['lat' => 44.8381, 'lng' => 11.6198],
        'Sassari' => ['lat' => 40.7259, 'lng' => 8.5598],
        'Latina' => ['lat' => 41.4677, 'lng' => 12.9038],
        'Giugliano in Campania' => ['lat' => 40.9292, 'lng' => 14.1940],
        'Monza' => ['lat' => 45.5845, 'lng' => 9.2744],
        'Siracusa' => ['lat' => 37.0755, 'lng' => 15.2866],
        'Pescara' => ['lat' => 42.4618, 'lng' => 14.2163],
        'Lecco' => ['lat' => 45.8564, 'lng' => 9.3987],
        'Valmadrera' => ['lat' => 45.8419, 'lng' => 9.3619],
        'Domodossola' => ['lat' => 46.1145, 'lng' => 8.2914],
        'DOMODOSSOLA' => ['lat' => 46.1145, 'lng' => 8.2914],
        'lecco' => ['lat' => 45.8564, 'lng' => 9.3987],
        'valmadrera' => ['lat' => 45.8419, 'lng' => 9.3619],
        'domodossola' => ['lat' => 46.1145, 'lng' => 8.2914],
        'roma' => ['lat' => 41.9028, 'lng' => 12.4964],
    ];

    public function handle()
    {
        $this->info('🗺️  Adding coordinates to events...');
        
        // Get events without coordinates
        $eventsWithoutCoords = Event::where(function($query) {
            $query->whereNull('latitude')
                  ->orWhereNull('longitude');
        })->get();
        
        $this->info("Found {$eventsWithoutCoords->count()} events without coordinates");
        
        $updated = 0;
        $skipped = 0;
        
        foreach ($eventsWithoutCoords as $event) {
            $city = $event->city;
            
            // If city is empty, use Roma as default
            if (empty($city)) {
                $city = 'Roma';
                $this->warn("Event '{$event->title}' has no city, using Roma as default");
            }
            
            // Try to find exact city match
            $coordinates = $this->cityCoordinates[$city] ?? null;
            
            // If not found, try case-insensitive search
            if (!$coordinates) {
                foreach ($this->cityCoordinates as $knownCity => $coords) {
                    if (strtolower($knownCity) === strtolower($city)) {
                        $coordinates = $coords;
                        break;
                    }
                }
            }
            
            if ($coordinates) {
                // Add small random offset to prevent exact overlapping
                // Offset is about 100-500 meters
                $latOffset = (rand(-50, 50) / 10000);
                $lngOffset = (rand(-50, 50) / 10000);
                
                $event->latitude = $coordinates['lat'] + $latOffset;
                $event->longitude = $coordinates['lng'] + $lngOffset;
                $event->save();
                
                $this->line("✅ {$event->title} ({$city}): [{$event->latitude}, {$event->longitude}]");
                $updated++;
            } else {
                $this->warn("⚠️  City not found: {$city} for event: {$event->title}");
                $skipped++;
            }
        }
        
        $this->newLine();
        $this->info("✅ Updated: {$updated} events");
        $this->warn("⚠️  Skipped: {$skipped} events (unknown cities)");
        $this->newLine();
        
        return Command::SUCCESS;
    }
}
