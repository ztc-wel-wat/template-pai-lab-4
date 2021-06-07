<?php if (!isset($portal)) die(); ?>
<div id="loginFormWrapper" class="forms">
  <form action="index.php?action=login" method="post">
    <table>
      <tr>
        <td>E-mail:</td>
        <td>
          <input type="text" name="email">
        </td>
      </tr>
      <tr>
        <td>Hasło:</td>
        <td>
          <input type="password" name="haslo">
        </td>
      </tr>
      <tr>
        <td>
          <a href="index.php?action=showRegistrationForm">Rejestracja</a>
        </td>
        <td>
          <input type="submit" value="Zaloguj">
        </td>
      </tr>
    </table>
  </form>
</div>