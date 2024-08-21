<div class="search-box">
    <form>
        <input style="width: 20em" id="search-box" name="key" placeholder="Search book title,description" value="{{ request('key') }}">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
        <button onclick="clearSearchBox()" type="button"><i class="fa-solid fa-trash-can"></i></button>
    </form>
</div><br>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function clearSearchBox(){
        $('#search-box').val('')
    }
</script>