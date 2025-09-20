<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div>
        <label for="name">Name</label>
        <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @if ($errors->has('name'))
            <div class="mt-2 text-red-600">
                {{ $errors->first('name') }}
            </div>
        @endif
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <label for="email">Email</label>
        <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        @if ($errors->has('email'))
            <div class="mt-2 text-red-600">
                {{ $errors->first('email') }}
            </div>
        @endif
    </div>

    <!-- Password -->
    <div class="mt-4">
        <label for="password">Password</label>
        <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password">
        @if ($errors->has('password'))
            <div class="mt-2 text-red-600">
                {{ $errors->first('password') }}
            </div>
        @endif
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password">
        @if ($errors->has('password_confirmation'))
            <div class="mt-2 text-red-600">
                {{ $errors->first('password_confirmation') }}
            </div>
        @endif
    </div>

    <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
            Already registered?
        </a>

        <button type="submit" class="ms-4 bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
            Register
        </button>
    </div>
</form>
