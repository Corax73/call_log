<?php

require_once '../../src/editing.php';
?>
<script>
    let allPhoneNumbers = '<?= json_encode($allPhoneNumbers) ?>';
</script>

<body>
    <div class="col-xs-4 col-md-6 col-lg-6">
        <h3 class="panel-title">Creating an operator</h3>
    </div>
    <div class="row row-cols-auto">
        <div class="col">
            <button class="btn btn-primary" id="operatorBtn">
                Operator creation form.
            </button>
        </div>
        <form method="POST" id="formOperator">
            <div class="form-group">
                <input required type="hidden" name="entity" class="form-control" value="operator">
                <label for="formGroupExampleInput">Title</label>
                <input required type="text" name="title" class="form-control" id="formGroupExampleInput" placeholder="Title" value="<?php if (isset($errors['errors']['operator']['entered_data']['title'])) print $errors['errors']['operator']['entered_data']['title'] ?>">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Internal price</label>
                <input required type="number" name="internal_price" class="form-control" id="formGroupExampleInput1" placeholder="Internal price" value="<?php if (isset($errors['errors']['operator']['entered_data']['internal_price'])) print $errors['errors']['operator']['entered_data']['internal_price'] ?>">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">External_price</label>
                <input required type="number" name="external_price" class="form-control" id="formGroupExampleInput2" placeholder="External_price" value="<?php if (isset($errors['errors']['operator']['entered_data']['external_price'])) print $errors['errors']['operator']['entered_data']['external_price'] ?>">
            </div>
            <?php if (isset($errors['errors']['operator'])) { ?><span class="text-danger"><?= $errors['errors']['operator']['error']; ?></span><?php } ?>
            <?php if (isset($saved['operator']) && $saved['operator']) { ?>
                <div class="alert alert-success" role="alert">
                    Operator saved!
                </div><?php } ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create operator</button>
            </div>
        </form>
    </div>
    <div class="col-xs-4 col-md-6 col-lg-6">
        <h3 class="panel-title">Creating a phone number</h3>
    </div>
    <div class="row row-cols-auto">
        <div class="col">
            <button class="btn btn-primary" id="phoneBtn">
                Phone number creation form.
            </button>
        </div>
        <form method="POST" id="formPhone">
            <div class="form-group">
                <input required type="hidden" name="entity" class="form-control" value="phoneNumber">
                <label for="formGroupExampleInput">Number</label>
                <input required type="number" name="number" class="form-control" id="formGroupExampleInput" placeholder="Number" value="<?php if (isset($errors['errors']['phoneNumber']['entered_data']['number'])) print $errors['errors']['phoneNumber']['entered_data']['number'] ?>">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">User</label>
                <select name="user_id" class="form-select" aria-label="Default select example" required>
                    <option selected>Open this select menu</option>
                    <?php if (isset($users) && count($users) > 0) { ?>
                        <?php foreach ($users as $email => $id) { ?>
                            <option value="<?= $id ?>" <?php if (isset($errors['errors']['phoneNumber']['entered_data']['user_id']) && $errors['errors']['phoneNumber']['entered_data']['user_id'] == $id) print 'selected' ?>><?= $email ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <?php if (isset($errors['errors']['phoneNumber'])) { ?><span class="text-danger"><?= $errors['errors']['phoneNumber']['error']; ?></span><?php } ?>
            <?php if (isset($saved['phoneNumber']) && $saved['phoneNumber']) { ?>
                <div class="alert alert-success" role="alert">
                    Phone number saved!
                </div><?php } ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create phone number</button>
            </div>
        </form>
    </div>
    <div class="col-xs-4 col-md-6 col-lg-6">
        <h3 class="panel-title">Creating a number binding to an operator</h3>
    </div>
    <div class="row row-cols-auto">
        <div class="col">
            <button class="btn btn-primary" id="numberOperatorBtn">
                Binding form.
            </button>
        </div>
        <form method="POST" id="formNumberOperator">
            <div class="form-group">
                <input required type="hidden" name="entity" class="form-control" value="numberOperators">
                <label for="formGroupExampleInput">Operator</label>
                <select name="operator_id" class="form-select" aria-label="Default select example" required>
                    <option selected>Open this select menu</option>
                    <?php if (isset($operators) && count($operators) > 0) { ?>
                        <?php foreach ($operators as $title => $id) { ?>
                            <option value="<?= $id ?>" <?php if (isset($errors['errors']['numberOperators']['entered_data']['operator_id']) && $errors['errors']['numberOperators']['entered_data']['operator_id'] == $id) print 'selected' ?>><?= $title ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Phone number</label>
                <select name="number_id" class="form-select" aria-label="Default select example" required>
                    <option selected>Open this select menu</option>
                    <?php if (isset($phoneNumbers) && count($phoneNumbers) > 0) { ?>
                        <?php foreach ($phoneNumbers as $number => $id) { ?>
                            <option value="<?= $id ?>" <?php if (isset($errors['errors']['numberOperators']['entered_data']['number_id']) && $errors['errors']['numberOperators']['entered_data']['number_id'] == $id) print 'selected' ?>><?= $number ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <?php if (isset($errors['errors']['numberOperators'])) { ?><span class="text-danger"><?= $errors['errors']['numberOperators']['error']; ?></span><?php } ?>
            <?php if (isset($saved['numberOperators']) && $saved['numberOperators']) { ?>
                <div class="alert alert-success" role="alert">
                    Binding saved!
                </div><?php } ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create binding</button>
            </div>
        </form>
    </div>
    <div class="col-xs-4 col-md-6 col-lg-6">
        <h3 class="panel-title">User number editing form</h3>
    </div>
    <div class="row row-cols-auto">
        <div class="col">
            <button class="btn btn-primary" id="usersNumbersBtn">
                Editing form.
            </button>
        </div>
        <form method="POST" id="formUsersNumbers">
            <div class="form-group">
                <input required type="hidden" name="entity" class="form-control" value="phoneNumber">
                <label for="formGroupExampleInput">Users</label>
                <select name="user_id" id="selectUser" class="form-select" aria-label="Default select example" required>
                    <option selected>Open this select menu</option>
                    <?php if (isset($usersWithPhoneNumbers) && count($usersWithPhoneNumbers) > 0) { ?>
                        <?php foreach ($usersWithPhoneNumbers as $user) { ?>
                            <option value="<?= $user['id'] ?>" <?php if (isset($errors['errors']['phoneNumber']['entered_data']['user_id']) && $errors['errors']['phoneNumber']['entered_data']['user_id'] == $id) print 'selected' ?>><?= $user['email'] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Users phone number</label>
                <input required type="number" name="number" class="form-control" id="userPhone" placeholder="" value="<?php if (isset($errors['errors']['formUsersNumbers']['entered_data']['number'])) print $errors['errors']['formUsersNumbers']['entered_data']['number'] ?>">
            </div>
            <?php if (isset($errors['errors']['formUsersNumbers'])) { ?><span class="text-danger"><?= $errors['errors']['formUsersNumbers']['error']; ?></span><?php } ?>
            <?php if (isset($saved['formUsersNumbers']) && $saved['formUsersNumbers']) { ?>
                <div class="alert alert-success" role="alert">
                    User's phone number changed successfully!
                </div><?php } ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create binding</button>
            </div>
        </form>
    </div>
    <script type="module" src="/js/editingForm.js"></script>
    <script type="text/javascript" src="/js/selectHandler.js"></script>
</body>