<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class TrainingTestController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['gender', 'email', 'postcode', 'address', 'building_name', 'opinion']);
        $contact['fullname'] = $request->input('first_name') . ' ' . $request->input('last_name');
        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {

        $gender = $request->input('gender');
        if ($gender === '男性') {
            $genderValue = 1;
        } elseif ($gender === '女性') {
            $genderValue = 2;
        } else {
            $genderValue = null;
        }

        $contact = $request->only(['email', 'postcode', 'address', 'building_name', 'opinion', 'fullname']);
        $contact['gender'] = $genderValue;

        Contact::create($contact);

        return view('thanks');
    }

}
