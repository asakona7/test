<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class SearchController extends Controller
{
public function search(Request $request)
{
    $fullname = $request->input('fullname');
    $gender = $request->input('gender');
    $created_at_start = $request->input('created_at_start');
    $created_at_end = $request->input('created_at_end');
    $email = $request->input('email');

    if ($fullname || $gender !== 'all' || $created_at_start || $created_at_end || $email) {
        $query = Contact::query()
            ->when($fullname, function ($query, $fullname) {
                $query->where('fullname', 'like', '%' . $fullname . '%')
                    ->orWhere('gender', 'like', '%' . $fullname . '%')
                    ->orWhere('email', 'like', '%' . $fullname . '%')
                    ->orWhere('created_at', 'like', '%' . $fullname . '%');
            });

        if ($gender !== 'all') {
            $query->where('gender', $gender);
        }

        if ($created_at_start) {
            $query->where('created_at', '>=', $created_at_start);
        }

        if ($created_at_end) {
            $query->where('created_at', '<=', $created_at_end);
        }

        $searchResults = $query->paginate(10);

        $request->session()->put('fullname', $fullname);
        $request->session()->put('gender', $gender);
        $request->session()->put('created_at_start', $created_at_start);
        $request->session()->put('created_at_end', $created_at_end);
        $request->session()->put('email', $email);
    } else {
        $searchResults = $request->session()->get('searchResults');
    }

    $oldfullname = $request->session()->get('fullname');
    $oldGender = $request->session()->get('gender', 'all');
    $oldCreatedAtStart = $request->session()->get('created_at_start');
    $oldCreatedAtEnd = $request->session()->get('created_at_end');
    $oldEmail = $request->session()->get('email');

    return view('search')->with([
        'searchResults' => $searchResults,
        'request' => $request,
        'oldfullname' => $oldfullname,
        'oldGender' => $oldGender,
        'oldCreatedAtStart' => $oldCreatedAtStart,
        'oldCreatedAtEnd' => $oldCreatedAtEnd,
        'oldEmail' => $oldEmail,
    ]);
}












    public function index(Request $request)
    {
        $fullname = $request->input('fullname');
        $gender = $request->input('gender');
        $created_at_start = $request->input('created_at_start');
        $created_at_end = $request->input('created_at_end');
        $email = $request->input('email');

        
        $query = Contact::query()
            ->when($fullname, function ($query, $fullname) {
                return $query->where('fullname', 'like', "%$fullname%");
            })
            ->when($email, function ($query, $email) {
                return $query->where('email', 'like', "%$email%");
            })
            ->when($created_at_start, function ($query) use ($created_at_start) {
                return $query->where('created_at', '>=', $created_at_start);
            })
            ->when($created_at_end, function ($query) use ($created_at_end) {
                return $query->where('created_at', '<=', $created_at_end);
            });

        if ($gender !== 'all') {
            $query->where('gender', $gender);
        }

        $results = $query->paginate(10);

        return view('search')->with([
            'searchResults' => $results,
            'request' => $request,
        ]);
    }





public function destroy(Request $request, $id)
{
    $contact = Contact::find($id);
    if ($contact) {
        $currentResults = $this->getSearchResults($request);
        $currentContactIds = $currentResults->pluck('id')->toArray();

        if (($key = array_search($id, $currentContactIds)) !== false) {
            unset($currentContactIds[$key]);
        }

        $contact->delete();

        $nextContactId = isset($currentContactIds[$key]) ? $currentContactIds[$key] : null;
        $nextContact = Contact::find($nextContactId);

        return response()->json(['message' => '削除が成功しました', 'nextContact' => $nextContact], 200);
    }

    return response()->json(['message' => '削除できませんでした'], 404);
}

private function getSearchResults(Request $request)
{

    $fullname = $request->input('fullname');
    $gender = $request->input('gender');
    $created_at_start = $request->input('created_at_start');
    $created_at_end = $request->input('created_at_end');
    $email = $request->input('email');

    $query = Contact::query()
        ->when($fullname, function ($query, $fullname) {
            return $query->where('fullname', 'like', "%$fullname%");
        })
        ->when($email, function ($query, $email) {
            return $query->where('email', 'like', "%$email%");
        })
        ->when($created_at_start, function ($query) use ($created_at_start) {
            return $query->where('created_at', '>=', $created_at_start);
        })
        ->when($created_at_end, function ($query) use ($created_at_end) {
            return $query->where('created_at', '<=', $created_at_end);
        });

    if ($gender !== 'all') {
        $query->where('gender', $gender);
    }

    return $query->paginate(10);
}





    public function boot()
    {
        Paginator::useBootstrap();
    }


}