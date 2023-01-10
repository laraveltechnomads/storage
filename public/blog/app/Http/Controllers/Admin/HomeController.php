<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function saveContact(Request $request){
        $request->validate([
            'name'       => 'sometimes|required',
            'email'      => 'sometimes|required|email|unique:contact_us',
            'service'    => 'sometimes|required',
            'mobile_no'  => 'sometimes|required',
            'message'    => 'sometimes|required',
        ]);
        ContactUs::create($request);
        return redirect()->route('admin.category.index')->with('success', 'Contact add successfully.');
    }
}
