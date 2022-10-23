<h1 class="text-5xl text-white font-bold">
    Welcome to the Home <?= $name ?>
    <form class="form" method="post" action="/contact">
        <label class="" for="name">
            Name
            <input class="form-input text-slate-900" id="name" type="text" name="name" >
        </label>
        <button class="text-xl" type="submit">
            Send
        </button>
    </form>
</h1>
