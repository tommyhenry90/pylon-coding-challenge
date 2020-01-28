<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ContactResource;
use App\Http\Resources\ContactCollection;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function index()
    {
        return new ContactCollection(Contact::paginate());
    }

    public function store(Request $request)
    {
        $data = $this->validate($request->all(), [
            'first_name' => 'string|required|max:255',
            'last_name' => 'string|present|max:255',
            'email' => 'string|present|max:255',
        ]);

        $contact = Contact::create($data);

        return new ContactResource($contact);
    }

    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    public function update(Request $request, Contact $contact)
    {
        if ($request->isMethod('patch')) {
            $data = $this->validate($request, [
                'first_name' => 'string|max:255',
                'last_name' => 'string|max:255',
                'email' => 'string|max:255',
            ]);
        } else {
            $data = $this->validate($request, [
                'first_name' => 'string|required|max:255',
                'last_name' => 'string|present|max:255',
                'email' => 'string|present|max:255',
            ]);
        }

        $contact->update($data);

        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->noContent();
    }
}
