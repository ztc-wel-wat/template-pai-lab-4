<?php if (!$this) die(); ?>
<div id="searchFormDiv" class="forms">
    <form action='index.php' method='GET'>
        <input type="hidden" name="action" value="searchBook">
        Autor:<input size='25' type='text' name='autor' value='<?= $autor ?>'>
        Tytuł:<input size='25' type='text' name='tytul' value='<?= $tytul ?>'>
        <input type='submit' value='Szukaj'>
    </form>
</div>