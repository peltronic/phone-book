<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PhonenumberCollection;
use App\Models\Phonenumber;

class PhonenumbersController extends Controller
{
    public function index(Request $request)
    {
        $data = Phonenumber::get();
        return new PhonenumberCollection($data);
    }

    public function destroy(Phonenumber $phonenumber)
    {
        $phonenumber->delete();
        return response()->json([]);
    }
}
