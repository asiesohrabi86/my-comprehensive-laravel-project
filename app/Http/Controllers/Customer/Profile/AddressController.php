<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;

class AddressController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('customer.profile.my-addresses', compact('provinces'));
    }
}
