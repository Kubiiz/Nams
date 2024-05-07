@if(!Auth::user()->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
        <x-alert :type="'danger'">
            {!! __('To continue using the website, please confirm your e-mail <b>:email</b>! A confirmation link was sent to your email.', ['email' => Auth::user()->email]) !!}<br />
            <button form="send-verification" class="underline text-sm text-blue-600 hover:text-blue-800">
                {{ __('Re-send the verification email.') }}
            </button>
            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
            @endif
        </x-alert>
    </div>
@elseif(isset($_GET['verified']))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
        <x-alert :type="'success'">
            {{ __('Thank you, Your email was successfully verified!') }}
        </x-alert>
    </div>
@endif
