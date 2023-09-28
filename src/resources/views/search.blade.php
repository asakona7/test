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
        <form class="form" action="/search" method="GET" id="search-form">
            @csrf
            <div class="sys__form">
                <p>
                <div class="sys__from--input">お名前</div>
                <input class="sys__input" type="text" name="fullname" value="{{ request('fullname') }}">
                </p>

<p class="radio__btn">
    <div class="sex">性別</div>
    <input type="radio" name="gender" value="all" id="all" style="transform:scale(2.5);" {{ !request()->has('gender') || request('gender') === 'all' ? 'checked' : '' }}>
    <label for="all"><span class="radio__btn">全て</span></label>
    <input type="radio" name="gender" value="1" id="men" style="transform:scale(2.5);" {{ request('gender') === '1' ? 'checked' : '' }}>
    <label for="men"><span class="radio__btn">男性</span></label>
    <input type="radio" name="gender" value="2" id="women" style="transform:scale(2.5);" {{ request('gender') === '2' ? 'checked' : '' }}>
    <label for="women"><span class="radio__btn">女性</span></label>
</p>
            </div>

            <div class="sys__form">
                <p>
                <div class="sys__from--input">登録日</div>
                <input class="sys__input" type="date" name="created_at_start" value="{{ request('created_at_start') }}">
                <span class="sys__cld">~</span>
                <input class="sys__input" type="date" name="created_at_end" value="{{ request('created_at_end') }}">
                </p>
            </div>
            <div class="sys__form">
                <p>
                <div class="sys__from--input--mail">メールアドレス</div>
                <input class="sys__input" type="text" name="email" value="{{ request('email') }}">
                </p>
            </div>
            <div class="form__button">
                <button class="sys__button-submit" type="submit">検索</button>
            </div>
            <div class="form__button--rst">
                <button class="sys__button-rst" type="button" id="clear-button">リセット</button>
            </div>
        </form>
    </div>

<div class="zenken">
    <div class="zenken__inner">
        @if ($searchResults)
            全{{ $searchResults->total() }}件中　{{ $searchResults->firstItem() }}～{{ $searchResults->lastItem() }}件
        @endif
    </div>
    @if ($searchResults)
        {{ $searchResults->appends(request()->query())->links('pagination::bootstrap-4', ['class' => 'current']) }}
    @endif
</div>



    <div class="rlt">
        <table class="rlt__table__inner">
            <tr class="sys_menu">
                <th class="rlt_ttl">ID</th>
                <th class="rlt_ttl">お名前</th>
                <th class="rlt_ttl">性別</th>
                <th class="rlt_ttl">メールアドレス</th>
                <th class="rlt_ttl" id="opinion">ご意見</th>
            </tr>
            @if ($searchResults->isEmpty())
    <p></p>
@else
@foreach ($searchResults as $result)
<tr class="sys_mem">
    <td class="rlt_ttl--data">{{ $result->id }}</td>
    <td class="rlt_ttl--data">{{ $result->fullname }}</td>
    <td class="rlt_ttl--data">
        @if ($result->gender === 1)
            男性
        @elseif ($result->gender === 2)
            女性
        @else
            不明
        @endif
    </td>
    <td class="rlt_ttl--data">{{ $result->email }}</td>
    <td class="rlt_ttl--data" id="opinion" data-text="{{ $result->opinion }}">
        {{ $result->opinion }}
    </td>
    <td class="rlt_ttl--data">
        <button class="rlt_btn-inner delete-button" data-id="{{ $result->id }}" type="button">削除</button>
    </td>
</tr>
@endforeach
            @endif
        </table>
    </div>
    @section('js')
        <script>
            const opinionCells = document.querySelectorAll('.rlt_ttl--data[data-text]');

            const maxCharacters = 25;

            opinionCells.forEach((opinionCell) => {
                const opinionText = opinionCell.getAttribute('data-text').trim();

                opinionCell.textContent = opinionText.length > maxCharacters
                    ? opinionText.slice(0, maxCharacters) + '…'
                    : opinionText;

                opinionCell.addEventListener('mouseover', function() {
                    this.textContent = opinionText;
                });
                opinionCell.addEventListener('mouseout', function() {
                    this.textContent = opinionText.length > maxCharacters
                        ? opinionText.slice(0, maxCharacters) + '…'
                        : opinionText;
                });
            });
        </script>

<script>
    $(document).ready(function() {
        $('.delete-button').on('click', function() {
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            $.ajax({
                url: '/contacts/delete/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(data) {
                    row.fadeOut('slow', function() {
                        $(this).remove();
                    });
                },
                error: function(data) {
                    console.log('削除エラー:', data);
                }
            });
        });
    });
</script>

<script>
    document.getElementById('clear-button').addEventListener('click', function () {
        document.querySelectorAll('input[type="radio"]').forEach(function (radio) {
            radio.checked = false;
        });
        document.querySelectorAll('input[type="text"]').forEach(function (textInput) {
            textInput.value = '';
        });
        document.querySelectorAll('input[type="date"]').forEach(function (dateInput) {
            dateInput.value = '';
        });
        document.querySelectorAll('input[type="email"]').forEach(function (emailInput) {
            emailInput.value = '';
        });
        resetRadioButtons();
    });

    function resetRadioButtons() {
        document.getElementById('all').checked = true;
    }
</script>






<script>
$(document).ready(function() {
    $('.delete-button').on('click', function() {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: '/contacts/delete/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(data) {
                if (data.nextContact) {
                    getNextDataAndAppend(row, data.nextContact);
                } else {
                    location.reload();
                }
            },
            error: function(data) {
                console.log('削除エラー:', data);
            }
        });
    });

    function getNextDataAndAppend(row, nextContact) {
        var newRowHtml = '<tr class="sys_mem">' +
            '<td class="rlt_ttl--data">' + nextContact.id + '</td>' +
            '<td class="rlt_ttl--data">' + nextContact.fullname + '</td>' +
            '<td class="rlt_ttl--data">' + (nextContact.gender === 1 ? '男性' : (nextContact.gender === 2 ? '女性' : '不明')) + '</td>' +
            '<td class="rlt_ttl--data">' + nextContact.email + '</td>' +
            '<td class="rlt_ttl--data" id="opinion" data-text="' + nextContact.opinion + '">' + nextContact.opinion + '</td>' +
            '<td class="rlt_ttl--data">' +
            '<button class="rlt_btn-inner delete-button" data-id="' + nextContact.id + '" type="button">削除</button>' +
            '</td>' +
            '</tr>';

        row.fadeOut('slow', function() {
            $(this).remove();
            row.after(newRowHtml);
        });
    }
});
</script>




    @endsection
@endsection