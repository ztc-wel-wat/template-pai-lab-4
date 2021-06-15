<?php if (!$this) die(); ?> 
<div id="bookDetailsDiv"> 
    <?php if ($komunikat) { ?> 
        <div class="komunikat"><?php echo $komunikat; ?></div> 
    <?php } else { ?> 
        <table> 
            <tr> 
                <td>Tytuł</td><td><?php echo $row['Tytul']; ?></td> 
                <td rowspan="7" class="textMiddle"> 
                    <a href="index.php?action=addToBasket&id=<?php echo $row['Id']; ?>">Do koszyka</a> 
                </td> 
            </tr> 
            <tr><td>Autor</td><td><?php echo $row['Autor']; ?></td></tr> 
            <tr><td>ISBN</td><td><?php echo $row['ISBN']; ?></td></tr> 
            <tr><td>Wydawnictwo</td><td><?php echo $row['Wydawnictwo']; ?></td></tr> 
            <tr><td>Rok wydania</td><td><?php echo $row['Rok']; ?></td></tr> 
            <tr><td>Cena</td><td><?php echo $row['Cena']; ?></td></tr> 
            <tr><td>Opis</td><td><?php echo $row['Opis']; ?></td></tr> 
        </table> 
    <?php } ?> 
</div>