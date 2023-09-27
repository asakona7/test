@extends('layouts.app')

@section('ttlbar')
    管理システム
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}"/>
@endsection

@section('ttl')
    管理システム
@endsection
@section('content')
    <div class="sys">
        <form class="form" action="/search" method="GET">
            <div class="sys__form">
                <p>
                <div class="sys__from--input">お名前</div>
                <input class="sys__input" type="text" name="fullname" value="{{ old('fullname', session('fullname')) }}">
                </p>

                <p class="radio__btn">
                <div class="sex">性別</div>

                <input type="radio" name="gender" value="all" id="all" style="transform:scale(2.5);" checked/>
                <label for="all"><span class="radio__btn">全て</span></label>
                <input type="radio" name="gender" value="1" id="men" style="transform:scale(2.5);">
                <label for="men"><span class="radio__btn">男性</span></label>
                <input type="radio" name="gender" value="2" id="women" style="transform:scale(2.5);"/>
                <label for="women">
                    <span class="radio__btn">女性</span>
                </label>
                </p>
            </div>

            <div class="sys__form">
                <p>
                <div class="sys__from--input">登録日</div>
                <input class="sys__input" type="date" name="created_at_start" value="{{ old('created_at_start') }}">
                <span class="sys__cld">~</span>
                <input class="sys__input" type="date" name="created_at_end" value="{{ old('created_at_end') }}">
                </p>
            </div>

            <div class="sys__form">
                <p>
                <div class="sys__from--input--mail">メールアドレス</div>
                <input class="sys__input" type="text" name="email" value="{{ old('email') }}">
                </p>
            </div>

            <div class="form__button">
                <button class="sys__button-submit" type="submit">検索</button>
            </div>
            <div class="form__button--rst">
                <button class="sys__button-rst" type="reset">リセット</button>
            </div>
        </form>
    </div>

    <div class="zenken">
        <div class="zenken__inner">全{{ $searchResults->total() }}件中　{{ $searchResults->firstItem() }}～{{ $searchResults->lastItem() }}件</div>
        {{ $searchResults->appends(request()->query())->links('pagination::bootstrap-4', ['class' => 'current']) }}
    </div>



    <div class="rlt">
        <table class="rlt__table__inner">
            <tr class="sys_menu">
                <th class="rlt_ttl">ID</th>
                <th class="rlt_ttl">
                    お名前
                </th>
                <th class="rlt_ttl">
                    性別
                </th>
                <th class="rlt_ttl">
                    メールアドレス
                </th>
                <th class="rlt_ttl" id="opinion">
                    ご意見
                </th>
            </tr>
            @foreach ($searchResults as $result)
                <tr class="sys_mem" l>
                    <td class="rlt_ttl--data">{{ $result->id }}</td>
                    <td class="rlt_ttl--data">{{ $result->fullname }}</td>
                    <td class="rlt_ttl--data">@if ($result->gender === 1)
                            男性
                        @elseif ($result->gender === 2)
                            女性
                        @else
                            不明
                        @endif</td>
                    <td class="rlt_ttl--data">{{ $result->email }}</td>
                    <td class="rlt_ttl--data" id="opinion" data-text="{{ $result->opinion }}">
                        {{ $result->opinion }}
                    </td>
                    <td class="rlt_ttl--data">
                        <form class="delete-form" action="/contacts/delete/{{ $result->id }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="rlt_btn-inner" type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    @section('js')
        <script>
            // opinionセルの要素を取得
            const opinionCells = document.querySelectorAll('.rlt_ttl--data[data-text]');

            // 表示する最大文字数
            const maxCharacters = 25;

            // opinionセルに対してループ処理を行う
            opinionCells.forEach((opinionCell) => {
                // opinionセル内のテキストを取得
                const opinionText = opinionCell.getAttribute('data-text').trim();

                // opinionセル内のテキストを省略表示に設定
                opinionCell.textContent = opinionText.length > maxCharacters
                    ? opinionText.slice(0, maxCharacters) + '…'
                    : opinionText;

                // マウスオーバー時のイベントリスナーを追加
                opinionCell.addEventListener('mouseover', function() {
                    // マウスオーバー時に全文を表示
                    this.textContent = opinionText;
                });

                // マウスアウト時のイベントリスナーを追加
                opinionCell.addEventListener('mouseout', function() {
                    // マウスアウト時に再び省略表示に戻す
                    this.textContent = opinionText.length > maxCharacters
                        ? opinionText.slice(0, maxCharacters) + '…'
                        : opinionText;
                });
            });
        </script>
    @endsection
@endsection
