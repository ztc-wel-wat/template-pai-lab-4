<?php if (!isset($portal)) die(); ?>
<div id="loginFormWrapper" class="forms">
    <form action="index.php?action=login" method="post">
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">E-mail: </label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="haslo" class="form-label">Haslo: </label>
                <input type="password" class="form-control" id="haslo" name="haslo">
            </div>
            <button type="submit" class="btn btn-primary">Zaloguj</button>
        </form>
</div>