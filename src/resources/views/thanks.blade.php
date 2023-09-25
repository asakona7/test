@extends('layouts.app')

@section('ttlbar')
    お問い合わせ完了
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}"/>
@endsection

@section('ttl')
    お問い合わせ送信完了
@endsection

@section('content')
    <div class="thanks">
        <p class="thanks__message">ご意見いただきありがとうございました。</p>
        <div class="thanks__top"><a href="/" class="thanks__top--inner">トップページに移動</a></div>
    </div>
    <p class="thanks__rtn">5秒後、自動的にお問い合わせフォームに戻ります。</p>
@endsection

@section('js')
    <script>
        setTimeout(function () {
            window.location.href = '/';
        }, 5 * 1000);
    </script>
@endsection
