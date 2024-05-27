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
    <div class="row">
        <div class="col-xs-4 col-md-6 col-lg-6">
            <h3 class="panel-title">Creating a phone number</h3>
        </div>
        <form method="POST">
            <div class="form-group">
                <input type="hidden" name="entity" class="form-control" value="phoneNumber">
                <label for="formGroupExampleInput">Number</label>
                <input type="number" name="number" class="form-control" id="formGroupExampleInput" placeholder="Number">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">User</label>
                <select name="user_id" class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <?php if (isset($users) && count($users) > 0) { ?>
                        <?php foreach($users as $email => $id) { ?>
                            <option value="<?= $id ?>"><?= $email ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <?php if (isset($errors['errors'])) { ?><span class="text-danger"><?= $errors['errors']; ?></span><?php } ?>
            <?php if (isset($saved) && $saved) { ?>
                <div class="alert alert-success" role="alert">
                    Phone number saved!
                </div><?php } ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create phone number</button>
            </div>
        </form>
    </div>
</body>