<?php if (!$this) die(); ?>
<div id="basketDiv">
    <?php if ($komunikat) { ?>
        <div class="komunikat"><?= $komunikat ?></div>
    <?php } else { ?>
        <form action="index.php?action=modifyBasket" method="post">
            <table>
                <tr>
                    <!-- Górny wiersz tabeli z tytułem -->
                    <td colspan="4" class="textMiddle"><?= $title ?></td>
                </tr>
                <tr>
                    <!-- Nagłówki kolumn -->
                    <th>Tytuł</th>
                    <th class="textRight">Cena</th>
                    <th class="textRight">Liczba</th>
                    <th class="textRight">Wartość</th>
                </tr>
                <tr>
                    <!-- Odczytanie wyników zapytania -->
                    <!-- Tutaj pętla while odczytująca listę książek -->
                    <?php
                    $suma = 0;
                    while ($row = $books->fetch_row()) { ?>
                <tr>
                    <td class="textLeft"><?php echo $row[1]; ?></td>
                    <td class="textRight"><?php echo $basket[$row[0]]->cena; ?></td>
                    <?php
                        // Liczba egzemplarzy i wartość dla danej książki
                        $ile = $basket[$row[0]]->ile;
                        $wartosc = $ile * $basket[$row[0]]->cena;
                        $wartosc = sprintf("%01.2f", $wartosc);
                        //Sumowanie całkowitej wartości koszyka
                        $suma += $wartosc;
                    ?>
                    <td class="textRight">
                        <?php if ($allowModify) { ?>
                            <!-- Jeżeli dopuszczamy modyfikację liczby egzemplarzy -->
                            <input type="text" name="<?php echo $basket[$row[0]]->id; ?>" value="<?php echo $ile; ?>" size="2" class="textRight">
                        <?php } else { ?>
                            <!-- Jeżeli podsumowujemy zamówienie -->
                            <?php echo $ile; ?>
                        <?php } ?>
                    </td>
                    <td class="textRight"><?php $wartosc ?></td>
                </tr>
            <?php } ?>
            <td colspan="3">Całkowita wartość</td>
            <td class="textRight"><?= sprintf("%01.2f", $suma) ?></td>
            </tr>
            <?php if ($allowModify) { ?>
                <tr>
                    <td colspan="4" class="textRight"><input type="submit" value="Zapisz zmiany"></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4" class="textRight">
                    <?php if ($allowModify) { ?>

                        <a href="index.php?action=checkout">Do kasy</a>
                    <?php } else { ?>
                        <a href="index.php?action=saveOrder">Złóż zamówienie</a>
                    <?php } ?>
                </td>
            </tr>
            </table>
        </form>
    <?php } ?>
</div>