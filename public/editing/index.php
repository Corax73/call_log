<?php

require_once '../../src/editing.php';
?>

<body>
    <div class="row">
        <div class="col-xs-4 col-md-6 col-lg-6">
            <h3 class="panel-title">Creating an operator</h3>
        </div>
        <form method="POST">
            <div class="form-group">
                <input type="hidden" name="entity" class="form-control" value="operator">
                <label for="formGroupExampleInput">Title</label>
                <input type="text" name="title" class="form-control" id="formGroupExampleInput" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Internal price</label>
                <input type="number" name="internal_price" class="form-control" id="formGroupExampleInput1" placeholder="Internal price">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">External_price</label>
                <input type="number" name="external_price" class="form-control" id="formGroupExampleInput2" placeholder="External_price">
            </div>
            <?php if (isset($errors['errors'])) { ?><span class="text-danger"><?= $errors['errors']; ?></span><?php } ?>
            <?php if (isset($saved) && $saved) { ?>
                <div class="alert alert-success" role="alert">
                    Operator saved!
                </div><?php } ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create operator</button>
            </div>
        </form>
    </div>
</body>