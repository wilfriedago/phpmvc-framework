<form id="form" action="/login" method="post" class="flex flex-col">
    <label for="email" class="text-gray-300 mb-2">Email</label>
    <input id="email" type="email" name="email" class="form-input mb-2">
    <label for="password" class="text-gray-300 mb-2">Password</label>
    <input id="password" type="password" name="password" class="form-input mb-2">
    <button type="submit" class="rounded mt-2 p-2 w-full bg-blue-500 text-white text-xl font-bold">
        Submit
    </button>
    <a class="mt-4 text-center text-xl text-white font-bold" href="/register">
        Go to register &rangle;
    </a>
</form>
