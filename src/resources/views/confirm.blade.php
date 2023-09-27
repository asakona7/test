@extends('layouts.app')

@section('ttlbar')
    内容確認
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}"/>
@endsection

@section('ttl')
    内容確認
@endsection

@section('content')
    <form class="form" action="/contacts" method="post">
        @csrf
        <div class="confirm-table">
            <div class="confirm-table__inner">
                <div class="confirm-table__row">
                    <div class="confirm-table__header">お名前</div>
                    <div class="confirm-table__text">
                        <input type="text" name="fullname" value="{{ $contact['fullname'] }}" readonly/>
                    </div>
                </div>

                <div class="confirm-table__row">
                    <div class="confirm-table__header">性別</div>
                    <div class="confirm-table__text">
                        <input type="text" name="gender" value="{{ $contact['gender'] }}" readonly/>
                    </div>
                </div>

                <div class="confirm-table__row">
                    <div class="confirm-table__header">メールアドレス</div>
                    <div class="confirm-table__text">
                        <input type="email" name="email" value="{{ $contact['email'] }}" readonly/>
                    </div>
                </div>

                <div class="confirm-table__row">
                    <div class="confirm-table__header">郵便番号</div>
                    <div class="confirm-table__text">
                        <input type="text" name="postcode" value="{{ $contact['postcode'] }}" readonly/>
                    </div>
                </div>

                <div class="confirm-table__row">
                    <div class="confirm-table__header">住所</div>
                    <div class="confirm-table__text">
                        <input type="text" name="address" value="{{ $contact['address'] }}" readonly/>
                    </div>
                </div>

                <div class="confirm-table__row">
                    <div class="confirm-table__header">建物名</div>
                    <div class="confirm-table__text">
                        <input type="text" name="building_name" value="{{ $contact['building_name'] }}" readonly/>
                    </div>
                </div>

                <div class="confirm-table__row">
                    <div class="confirm-table__header">お問い合わせ内容</div>
                    <div class="confirm-table__text">
                        <textarea id="opinion" name="opinion" readonly>{{ $contact['opinion'] }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">送信</button>
        </div>
    </form>
    </div>
    <div class="form__button-rtn">
        <a class="form__button-rtn-inner" onclick=history.back()>修正する</a>
    </div>
@endsection
