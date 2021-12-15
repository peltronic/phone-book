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
        $request->validate([
            'q' => 'string', // value to search for
        ]);

        $query = Contact::query();

        // %FIXME: move to scope
        if ( $request->has('q') && $request->q!=='' ) {
            $qStr = $request->q;
            $query->whereHas('phonenumbers', function($q1) use($qStr) {
                $q1->where('phonenumber', 'LIKE', '%'.$qStr.'%');
            });
            $query->orWhere( function($q1) use($qStr) {
                $q1->where('firstname', 'LIKE', $qStr.'%')->orWhere('lastname', 'LIKE', $qStr.'%');
            });
        }

        $list = $query->orderBy('created_at', 'desc')->get();

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

        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json([]);
    }
}
