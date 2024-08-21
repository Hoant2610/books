<div style="display: flex;justify-content: space-between;" class="search-box">
    <form method="GET" action="{{route('find-book')}}">
        <input style="width: 400px" id="search-box" name="key" placeholder="Search book title,description" value="{{ request('key') }}">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
        <button onclick="clearSearchBox()" type="button"><i class="fa-solid fa-trash-can"></i></button>
    </form>
    <div class="create-book">
        <a style="text-decoration: none;cursor: pointer;color: inherit;" href="/admin/book/create-book"><button>Create</button></a>
    </div>
</div>
<br>
<script>
    function clearSearchBox(){
        $('#search-box').val('')
    }
</script>