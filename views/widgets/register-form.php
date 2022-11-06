<form id="form" action="/register" method="post" class="flex flex-col">
    <label for="firstname" class="text-gray-300 mb-2">Firstname</label>
    <span id="firstname-invalid" class="hidden text-xs text-red-500"></span>
    <input id="firstname" type="text" name="firstname" autocomplete="firstname" minlength="4" class="form-input mb-2">

    <label for="lastname" class="text-gray-300 mb-2">Lastname</label>
    <span id="lastname-invalid" class="hidden text-xs text-red-500"></span>
    <input id="lastname" type="text" name="lastname" autocomplete="lastname" minlength="4" class="form-input mb-2">

    <label for="username" class="text-gray-300 mb-2">Username</label>
    <span id="username-invalid" class="hidden text-xs text-red-500"></span>
    <input id="username" type="text" name="username" autocomplete="username" minlength="4" class="form-input mb-2">

    <label for="email" class="text-gray-300 mb-2">Email</label>
    <span id="email-invalid" class="hidden text-xs text-red-500"></span>
    <input id="email" type="email" name="email" maxlength="64" autocomplete="email" class="form-input mb-2">

    <label for="password" class="text-gray-300 mb-2">Password</label>
    <span id="password-invalid" class="hidden text-xs text-red-500"></span>
    <input id="password" type="password" name="password" minlength="8" autocomplete="new-password" class="form-input mb-2">

    <label for="passwordConfirm" class="text-gray-300 mb-2">Password Confirmation</label>
    <span id="passwordConfirm-invalid" class="hidden text-xs text-red-500"></span>
    <input id="passwordConfirm" type="password" name="passwordConfirm" autocomplete="new-password" class="form-input mb-2">

    <button type="submit" id="submitBtn" class="rounded mt-2 p-2 w-full bg-blue-500 text-white text-xl font-bold">
        Submit
    </button>
    <a class="mt-4 text-center text-xl text-white font-bold" href="/login">
        Go to login
    </a>
</form>
