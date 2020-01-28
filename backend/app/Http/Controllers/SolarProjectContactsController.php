<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\SolarProject;
use App\Http\Resources\ContactCollection;

class SolarProjectContactsController extends Controller
{
    public function index(SolarProject $solar_project)
    {
        return new ContactCollection($solar_project->contacts()->paginate());
    }

    public function update(Request $request, SolarProject $solar_project)
    {
        $data = $request->input('data');

        $newContacts = collect([]);
        foreach ($data as $datum) {
            if ($d['type'] !== 'contacts') {
                throw new \Exception('Related items be of type "contacts"');
            }
            $contactId = Contact::where('uuid', $d['id'])->firstOrFail()->id;
            $newContacts->push($contactId);
        }

        $solar_project->contacts()->sync($newContacts);

        return new ContactCollection($solar_project->contacts()->paginate());
    }
}
