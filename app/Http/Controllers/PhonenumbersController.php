<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PhonenumberCollection;
use App\Models\Phonenumber;

class PhonenumbersController extends Controller
{
    public function index(Request $request)
    {
        $list = Phonenumber::get();
        return new PhonenumberCollection($list);
    }

    // Remove a phone number, but not the contact itself
    public function destroy(Phonenumber $phonenumber)
    {
        $phonenumber->delete();
        return response()->json([]);
    }
}
