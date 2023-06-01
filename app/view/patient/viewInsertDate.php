<!-- ----- début viewInsert -->

<?php
require(VIEW_DIR . 'fragment/fragmentHeader.php');
?>

<body>
<?php
include VIEW_DIR . 'fragment/fragmentMenu.php';
?>
<div class="pb-3 container bg-light-subtle">
    <?php
    include VIEW_DIR . 'fragment/fragmentTitleSection.php';
    ?>
    <form role="form" class="px-5" method='get' action='rendez-vous/cree'>
        <div class="form-group pb-4 d-flex justify-content-between gap-5">
            <input type="hidden" name='entity[doctor_id]' value='<?= $args['entity']['doctor_id'] ?>'>
            <div class="form-group form-floating mb-4">
                <select class="form-select" id='appt' name='entity[appt]'>
                    <?php
                    foreach ($results as $result) {
                        printf("<option value='%s'>%s</option>", $result['disponibilité'], $result['disponibilité']);
                    }
                    ?>
                </select>
                <label for="appt">Sélectionner une date : </label>
            </div>
        </div>
        <button class="btn btn-primary w-100" type="submit">Ajouter</button>
        <hr>
    </form>
</div>
<?php
include VIEW_DIR . 'fragment/fragmentFooter.php'; ?>

<!-- ----- fin viewInsert -->



