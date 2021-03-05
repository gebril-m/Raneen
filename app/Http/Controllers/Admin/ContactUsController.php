<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;

class ContactUsController extends Controller
{
    public function show()
    {
        $data = Contact::get();
        return view('admin.contactuser',compact('data'));
    }
}
