<?php
//use Quiz\Models\User;
?>
<div class="container">
    <form id="user-form" action="/ajax">
        <input id="name" type="text" name="username">
        <input type="submit" value="Send">
    </form>
</div>
<script>
    (function () {
        let form = document.getElementById('user-form');

        console.log(form);
        form.addEventListener("submit", function (evt) {
            evt.preventDefault();
            let name = document.getElementById("name");
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/ajax/save');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status !== 200) {
                    return console.log("Error!");
                }
                console.log('Resp: ', xhr.responseText);
                let response = JSON.parse(xhr.responseText);

                if (response.message === 0) {
                    return alert(response.error);
                }
                return console.log("Seuccess!");
            };

            let data = 'name=' + name.value;
            xhr.send(encodeURI(data));
        });

    })();
</script>