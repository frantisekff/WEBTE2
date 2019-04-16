<html>
<head>
    <script>


        function showUser() {

                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","table.php",true);
                xmlhttp.send();
            }
        window.setInterval(function(){ showUser() }, 1000);
    </script>
</head>
<body>

<form>
    <select name="users" onchange="showUser(this.value)">
        <option value="">Select a person:</option>
        <option value="1">Peter Griffin</option>
        <option value="2">Lois Griffin</option>
        <option value="3">Joseph Swanson</option>
        <option value="4">Glenn Quagmire</option>
    </select>
</form>
<br>
<div id="txtHint"><b>Person info will be listed here...</b></div>

</body>
</html>