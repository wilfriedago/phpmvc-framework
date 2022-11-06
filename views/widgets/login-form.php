<form id="form" action="/login" method="post" class="flex flex-col">
    <label for="email" class="text-gray-300 mb-2">Email</label>
    <span id="email-invalid" class="hidden text-xs text-red-500"></span>
    <input id="email" type="email" name="email" maxlength="64" autocomplete="email" class="form-input mb-2">

    <label for="password" class="text-gray-300 mb-2">Password</label>
    <span id="password-invalid" class="hidden text-xs text-red-500"></span>
    <input id="password" type="password" name="password" minlength="8" autocomplete="current-password" class="form-input mb-2">

    <button type="submit" class="rounded mt-2 p-2 w-full bg-blue-500 text-white text-xl font-bold">
        Submit
    </button>
    <a class="mt-4 text-center text-xl text-white font-bold" href="/register">
        Go to register
    </a>
</form>
