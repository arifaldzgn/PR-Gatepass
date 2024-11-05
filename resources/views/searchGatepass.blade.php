<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/_searchticket.css " media="all" />
</head>
<body>
    <div class="flexbox">
        <div class="search">
          <h1>Search gatepass request</h1>
          <h3>Click on search icon, then type office number (ex: 20 10 001), press <b>Enter.</b></h3>
          <div>
            <input class="asa" type="text" id="searchInput" placeholder="Input Office Number . . ." required>
          </div>
        </div>
    </div>
</body>
<script>
    var input = document.getElementById("searchInput");

    input.addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            performSearch();
        }
    });

    function performSearch() {
        var searchTerm = input.value.trim();
        window.location.href = "/printTicket/" + encodeURIComponent(searchTerm);
    }
</script>
</html>
