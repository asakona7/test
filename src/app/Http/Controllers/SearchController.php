<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // フォームから送信された検索条件を取得
        $fullname = $request->input('fullname');
        $gender = $request->input('gender');
        $created_at_start = $request->input('created_at_start');
        $created_at_end = $request->input('created_at_end');
        $email = $request->input('email');

        // Contact モデルでの検索クエリを構築
        $query = Contact::query()
            ->when($fullname, function ($query, $fullname) {
                $query->where('fullname', 'like', '%' . $fullname . '%')
                    ->orWhere('gender', 'like', '%' . $fullname . '%')
                    ->orWhere('email', 'like', '%' . $fullname . '%')
                    ->orWhere('created_at', 'like', '%' . $fullname . '%');
            });

        // 性別が「全て」以外の場合、性別条件を追加
        if ($gender !== 'all') {
            $query->where('gender', $gender);
        }

        // 登録日の範囲条件を追加
        if ($created_at_start) {
            $query->where('created_at', '>=', $created_at_start);
        }

        if ($created_at_end) {
            $query->where('created_at', '<=', $created_at_end);
        }

        // ページネーションを適用
        $searchResults = $query->paginate(5);
        $searchResults = $request->session()->get('searchResults');

        // 検索フォームの入力内容をセッションに保存
        $request->session()->put('fullname', $fullname);
        $request->session()->put('gender', $gender);
        $request->session()->put('created_at_start', $created_at_start);
        $request->session()->put('created_at_end', $created_at_end);
        $request->session()->put('email', $email);

        return view('search')->with([
            'searchResults' => $searchResults, // セッションから取得した検索結果（ページネーションを含む）
            'request' => $request, // リクエストデータ（検索フォームの入力値など）
        ]);
    }





    public function index(Request $request)
    {
        $fullname = $request->input('fullname');
        $gender = $request->input('gender');
        $created_at_start = $request->input('created_at_start'); // 修正
        $created_at_end = $request->input('created_at_end');     // 修正
        $email = $request->input('email');

        // データベースから検索
        $query = Contact::query()
            ->when($fullname, function ($query, $fullname) {
                return $query->where('fullname', 'like', "%$fullname%");
            })
            ->when($email, function ($query, $email) {
                return $query->where('email', 'like', "%$email%");
            })
            ->when($created_at_start, function ($query) use ($created_at_start) { // 修正
                return $query->where('created_at', '>=', $created_at_start);     // 修正
            })
            ->when($created_at_end, function ($query) use ($created_at_end) {     // 修正
                return $query->where('created_at', '<=', $created_at_end);         // 修正
            });

        // 性別が「全て」以外の場合、性別条件を追加
        if ($gender !== 'all') {
            $query->where('gender', $gender);
        }

        // ページネーションを適用
        $results = $query->paginate(10);

        // 検索結果をビューに渡して表示
        return view('search')->with([
            'searchResults' => $results, // 検索結果
            'request' => $request, // リクエストデータ（検索フォームの入力値など）
        ]);
    }


    public function destroy(Request $request, $id)
    {
        // Contact モデルからコンタクトを削除
        $contact = Contact::find($id);
        if ($contact) {
            $contact->delete();
        }

        // 削除後にも検索結果を取得し直してセッションに保存
        $searchResults = Contact::query()->paginate(10); // ページネーションの件数を合わせる
        $request->session()->put('searchResults', $searchResults);

        // 削除後にリダイレクト
        return redirect()->route('contacts.search');
    }

    public function boot()
    {
        Paginator::useBootstrap();
    }


}
