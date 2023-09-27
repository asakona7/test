<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $data = DB::table('contacts')->paginate(5);

        return view('search', compact('data'));
    }
}
