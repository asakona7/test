@extends('layouts.app')

@section('ttlbar')
    お問い合わせ
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
@endsection

@section('ttl')
    お問い合わせ
    <p class=note><span class=note__inner>※</span>印のある項目は入力必須です。</p>
@endsection

@section('content')
    <div class="contact-form__content">
        <form class="form" action="/contacts/confirm" method="post">
            @csrf
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お名前</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text-name">
                        <input type="text" name="first_name" value="{{ old('first_name') }}"/>
                        <div class="form__error"></div>
                    </div>
                    <div class="form__input--text-name">
                        <input type="text" name="last_name" value="{{ old('last_name') }}"/>
                        <div class="form__error"></div>
                    </div>
                </div>
            </div>
            <div class="form__example">
                <div class="form__example-1">
                    <span>例）山田</span>
                </div>
                <div class="form__example-2">
                    <span>例）太郎</span>
                </div>
            </div>

            <div class="form__group radio__btn">
                <div class="form__group-title">
                    <span class="form__label--item">性別</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="radio">
                    <p class="radio__btn">
                        <input type="radio" name="gender" value="男性" id="men" style="transform:scale(1.5);" checked/>
                        <label for="men"><span class="radio__label-text">男性</span></label>
                    </p>
                    <p class="radio__btn">
                        <input type="radio" name="gender" value="女性" id="women" style="transform:scale(1.5);"/>
                        <label for="women"><span class="radio__label-text">女性</span></label>
                    </p>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">メールアドレス</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="email" name="email" value="{{ old('email') }}"/>
                        <div class="form__error"></div>
                    </div>
                </div>
            </div>
            <div class="form__example">
                <div class="form__example-1">
                    <span>例）test@example.com</span>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">郵便番号</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--postcode">
                        <span class="form__postcode">〒</span>
                        <input type="text" id="postcode" name="postcode" size="10" maxlength="8"
                            onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" value="{{ old('postcode') }}"/>
                        <div class="form__error"></div>
                    </div>
                </div>
            </div>
            <div class="form__example">
                <div class="form__example-1">
                    <span>例）123-4567</span>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="address" size="10" value="{{ old('address') }}"/>
                        <div class="form__error"></div>
                    </div>
                </div>
            </div>
            <div class="form__example">
                <div class="form__example-1">
                    <span>例）東京都渋谷区千駄ヶ谷1-2-3</span>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="building_name" value="{{ old('building_name') }}"/>
                        <div class="form__error"></div>
                    </div>
                </div>
            </div>
            <div class="form__example">
                <div class="form__example-1">
                    <span>例）千駄ヶ谷マンション101</span>
                </div>
            </div>

            <div class="form__group-opinion">
                <div class="form__group-title">
                    <span class="form__label--item">ご意見</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--textarea">
                        <textarea name="opinion" value="{{ old('opinion') }}"></textarea>
                        <div class="form__error"></div>
                    </div>
                </div>
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">確認</button>
            </div>
        </form>
    </div
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const firstNameInput = document.querySelector('input[name="first_name"]');
            const lastNameInput = document.querySelector('input[name="last_name"]');
            const emailInput = document.querySelector('input[name="email"]');
            const postcodeInput = document.querySelector('input[name="postcode"]');
            const addressInput = document.querySelector('input[name="address"]');
            const opinionTextarea = document.querySelector('textarea[name="opinion"]');
            const submitButton = document.querySelector('button[type="submit"]');

            // フォームデータをバリデーション
            submitButton.addEventListener('click', function(event) {
                if (!validateForm()) {
                    event.preventDefault(); // フォーム送信をブロック
                    alert('必須項目に空欄、もしくはエラーはあります。修正してください。');
                }
            });

            firstNameInput.addEventListener('input', validateFirstName);
            lastNameInput.addEventListener('input', validateLastName);
            emailInput.addEventListener('input', validateEmail);
            postcodeInput.addEventListener('input', validatePostcode);
            addressInput.addEventListener('input', validateAddress);
            opinionTextarea.addEventListener('input', validateOpinion);

            function validateForm() {
                // フォーム全体のバリデーションを実行
                const isValidFirstName = validateFirstName();
                const isValidLastName = validateLastName();
                const isValidEmail = validateEmail();
                const isValidPostcode = validatePostcode();
                const isValidAddress = validateAddress();
                const isValidOpinion = validateOpinion();

                // すべてのフィールドがバリデーションを通過しなければフォームは無効
                return isValidFirstName && isValidLastName && isValidEmail && isValidPostcode && isValidAddress && isValidOpinion;
            }

            function validateFirstName() {
                const firstNameValue = firstNameInput.value.trim();
                const errorContainer = firstNameInput.nextElementSibling;

                const errorMessage = document.createElement('div');
                errorMessage.classList.add('form__error');

                if (firstNameValue === "") {
                    errorMessage.textContent = '名字を入力してください';
                } else if (firstNameValue.length > 255) {
                    errorMessage.textContent = '名字は255文字以内で入力してください';
                } else {
                    while (errorContainer.firstChild) {
                        errorContainer.removeChild(errorContainer.firstChild);
                    }
                    return true;
                }

                errorContainer.innerHTML = '';
                errorContainer.appendChild(errorMessage);
                return false;
            }

            function validateLastName() {
                const lastNameValue = lastNameInput.value.trim();
                const errorContainer = lastNameInput.nextElementSibling;

                const errorMessage = document.createElement('div');
                errorMessage.classList.add('form__error');

                if (lastNameValue === "") {
                    errorMessage.textContent = '名前を入力してください';
                } else if (lastNameValue.length > 255) {
                    errorMessage.textContent = '名前は255文字以内で入力してください';
                } else {
                    while (errorContainer.firstChild) {
                        errorContainer.removeChild(errorContainer.firstChild);
                    }
                    return true;
                }

                errorContainer.innerHTML = '';
                errorContainer.appendChild(errorMessage);
                return false;
            }

            function validateEmail() {
                const emailValue = emailInput.value.trim();
                const errorContainer = emailInput.nextElementSibling;

                const errorMessage = document.createElement('div');
                errorMessage.classList.add('form__error');

                const emailRegex = /^[A-Za-z0-9+_.-]+@(.+)$/;
                if (emailValue === "") {
                    errorMessage.textContent = 'メールアドレスを入力してください';
                } else if (!emailRegex.test(emailValue)) {
                    errorMessage.textContent = '有効なメールアドレス形式を入力してください';
                } else if (emailValue.length > 255) {
                    errorMessage.textContent = 'メールアドレスは255文字以内で入力してください';
                } else {
                    while (errorContainer.firstChild) {
                        errorContainer.removeChild(errorContainer.firstChild);
                    }
                    return true;
                }

                errorContainer.innerHTML = '';
                errorContainer.appendChild(errorMessage);
                return false;
            }

            function validatePostcode() {
                const postcodeValue = postcodeInput.value.trim();
                const errorContainer = postcodeInput.nextElementSibling;

                const errorMessage = document.createElement('div');
                errorMessage.classList.add('form__error');

                const postcodeRegex = /^\d{3}-\d{4}$/;
                if (postcodeValue === "") {
                    errorMessage.textContent = '郵便番号を入力してください';
                } else if (!postcodeRegex.test(postcodeValue)) {
                    errorMessage.textContent = '郵便番号は数字とハイフンの8桁で入力してください';
                } else {
                    while (errorContainer.firstChild) {
                        errorContainer.removeChild(errorContainer.firstChild);
                    }
                    return true;
                }

                errorContainer.innerHTML = '';
                errorContainer.appendChild(errorMessage);
                return false;
            }

            function validateAddress() {
                const addressValue = addressInput.value.trim();
                const errorContainer = addressInput.nextElementSibling;

                const errorMessage = document.createElement('div');
                errorMessage.classList.add('form__error');

                if (addressValue === "") {
                    errorMessage.textContent = '住所を入力してください';
                } else if (addressValue.length > 255) {
                    errorMessage.textContent = '住所は255文字以内で入力してください';
                } else {
                    while (errorContainer.firstChild) {
                        errorContainer.removeChild(errorContainer.firstChild);
                    }
                    return true;
                }

                errorContainer.innerHTML = '';
                errorContainer.appendChild(errorMessage);
                return false;
            }

            function validateOpinion() {
                const opinionValue = opinionTextarea.value.trim();
                const errorContainer = opinionTextarea.nextElementSibling;

                const errorMessage = document.createElement('div');
                errorMessage.classList.add('form__error');

                if (opinionValue === "") {
                    errorMessage.textContent = 'お問い合わせ内容を入力してください';
                } else if (opinionValue.length > 255) {
                    errorMessage.textContent = 'お問い合わせ内容は255文字以内で入力してください';
                } else {
                    while (errorContainer.firstChild) {
                        errorContainer.removeChild(errorContainer.firstChild);
                    }
                    return true;
                }
                errorContainer.innerHTML = '';
                errorContainer.appendChild(errorMessage);
                return false;
            }
        });
    </script>

    <script>
        const postcodeInput = document.getElementById('postcode');
        postcodeInput.addEventListener('input', function () {
            let value = this.value.replace(/-/g, '');
            if (value.length >= 3) {
                value = value.slice(0, 3) + '-' + value.slice(3);
            }
            this.value = value;
        });
    </script>
    <script>
        $('.input-zip').on('change', function () {
            this.reportValidity();
        });
    </script>
@endsection
