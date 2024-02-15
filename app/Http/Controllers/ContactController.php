<?php

// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function importHubSpotContacts()
    {
        // Replace 'YOUR_HUBSPOT_API_KEY' with your actual HubSpot API key
        $apiKey = 'pat-na1-62f366fc-f24c-48b2-a6bb-5b6ebee978ee';

        // Make a GET request to HubSpot API to fetch contacts
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->get('https://api.hubapi.com/crm/v3/objects/contacts');
        
       
        // Check if the request was successful (status code 200)
        if ($response->successful()) {
            $hubSpotContacts = $response->json()['results'];

            // Iterate through HubSpot contacts and store them in the Laravel 'contacts' table
            foreach ($hubSpotContacts as $hubSpotContact) {
                Contact::updateOrCreate(
                    ['email' => $hubSpotContact['properties']['email']],
                    [
                        'first_name' => $hubSpotContact['properties']['firstname'] ?? null,
                        'last_name' => $hubSpotContact['properties']['lastname'] ?? null,
                        // Add other fields as needed
                    ]
                );
            }

            return response()->json(['message' => 'HubSpot contacts imported successfully']);
        } else {
            return response()->json(['error' => 'Failed to fetch HubSpot contacts'], $response->status());
        }
    }
}
