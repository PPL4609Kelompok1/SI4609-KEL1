<!-- Forum input card -->
<div class="bg-white p-4 rounded-lg mb-4" id="forumBox">
    <h1 class="font-semibold text-l mb-1">CREATE NEW FORUM</h1>

    <form method="POST" action="{{ route('forum.store') }}" class="transition-all duration-300" id="descForm">
        @csrf

        <!-- Trigger sekaligus input form -->
        <div class="flex items-center mb-4">
            <div class="flex-1">
                <input name="title" type="text" placeholder="Add New Forum | Create Title"
                    class="bg-transparent outline-none text-black w-full" id="titleInput"
                    onfocus="showDescription()" required />
            </div>
            <img alt="Add icon" class="ml-2 w-10 h-10" src="https://img.icons8.com/ios-filled/50/plus-math.png" />
        </div>

        <!-- Form detail -->
        <div id="extraFields" class="hidden">
            <textarea name="description" placeholder="Enter description..." class="w-full p-2 border rounded mb-2" required></textarea>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-400">Post</button>
        </div>
    </form>
</div>

<script>
    // Buat variabel buat nampung input user
    const forumBox = document.getElementById("forumBox");
    const extraFields = document.getElementById("extraFields");
    const titleInput = document.getElementById("titleInput");

    function showDescription() {
        extraFields.classList.remove("hidden");
    }

    document.addEventListener("click", function (event) {
        if (!forumBox.contains(event.target)) {
            extraFields.classList.add("hidden");
            titleInput.value = "";
        }
    });
</script>
