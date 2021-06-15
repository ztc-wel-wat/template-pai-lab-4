<?php if (!$this) die(); ?> 
<div id="registrationFormDiv" class="forms"> 
    <h2>Wprowadź dane do rejestracji:</h2> 
    <form name="regForm" action="index.php?action=registerUser" method="POST"> 
        <table> 
            <?php foreach ($formData as $input) { ?> 
                <tr> 
                    <td class="col1st"><?php echo $input->description; ?></td> 
                    <td class="col2ns"><?php echo $input->getInputHTML(); ?></td> 
                </tr> 
            <?php } ?> 
            <tr> 
                <td colspan="2" class="colmerged"> 
                    <input type="submit" value="Rejestracja"> 
                </td> 
            </tr> 
        </table> 
    </form> 
</div>