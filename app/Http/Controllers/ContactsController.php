<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;

use App\Models\Phonenumber;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $list = Contact::get();
        return new ContactCollection($list);
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'string',
            'phonenumber' => 'required|string',
        ]);
        $contact = Contact::create( $request->only(['firstname','lastname']) );
        $contact->phonenumbers()->create([
            'phonenumber' => $request->phonenumber,
        ]);
        $contact->load('phonenumbers');
        $contact->refresh();
//dd($contact);
//dd($contact->phonenumbers);
        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json([]);
    }
}
