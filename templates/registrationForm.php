<?php if (!$this) die(); ?>
<div id="registrationFormDiv" class="forms">
    <h2>Wprowadź dane do rejestracji:</h2>
    <form name="regForm" action="index.php?action=registerUser" method="POST">
        <table>
            <?php foreach ($formData as $input) { ?>
                <div class="mb-3">
                    <label class="form-label"><?php echo $input->description; ?></label>
                    <?php echo $input->getInputHTML(); ?>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Rejestracja</button>
    </form>
</div>

<form>
  