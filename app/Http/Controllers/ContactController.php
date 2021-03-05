<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContactController extends Controller
{
    public function index(Request $request){
        $first_name = trim(strip_tags($request->get('first_name')));
        $last_name = trim(strip_tags($request->get('last_name')));
        $email = trim(strip_tags($request->get('email')));
        $phone = trim(strip_tags($request->get('phone')));
        $message = trim(strip_tags($request->get('message')));
        $name = $first_name . ' '. $last_name ;
        $contact = new Contact() ;
        $contact->name = $name ;
        $contact->email = $email ;
        $contact->phone = $phone ;
        $contact->message = $message ;
        $contact->save();
        return redirect()->to('/'.App::getLocale());
    }
}
