<h3>Account Settings</h3>
<form class="well" method="post" action="<?php check_string(url('')) ?>">
<h4>User Profile Information</h4>
<?php if ($error_input): ?>
    <h5 class="alert alert-block">Invalid Input</h5>
<?php endif ?>

    <ul style='list-style:none;'>
        <?php foreach ($user as $v): ?>
            <li><?php echo "Edit First Name: "?></li>
            <input type="text" class="span2" name="firstname" placeholder="<?php check_string($v->firstname) ?>" value="<?php check_string(Param::get('firstname')) ?>">
            <br>
            <li><?php echo "Edit Last Name: "?></li>
            <input type="text" class="span2" name="lastname" placeholder="<?php check_string($v->lastname) ?>" value="<?php check_string(Param::get('lastname')) ?>">
            <br>
            <li><?php echo "Edit Email Address: "?></li>
            <input type="email" class="span2" name="email" placeholder="<?php check_string($v->email) ?>" value="<?php check_string(Param::get('email')) ?>">
            <br>
        <?php endforeach ?>
    </ul>
    <input type="hidden" name="user_id" value="<?php check_string($user->id) ?>">
    <input type="hidden" name="page_next" value="write_success">
    <button type="submit" name="save" class="btn btn-inverse">Save</button>
</form> 

<form class="well" method="post" action="<?php check_string(url('')) ?>">
<h4>Change Password</h4>

<?php if (!isset($save) && $error): ?>
    <div class="alert alert-block">
        <h5 class="alert-heading">Password Mismatch</h5>
    </div>
<?php endif ?>

    <ul style='list-style:none;'>
        <li><?php echo "Old Password: "?></li>
        <input type="password" class="span2" name="password" placeholder="Old Password" value="<?php check_string(Param::get('password')) ?>">
        <br>
        <li><?php echo "New Password: "?></li>
        <input type="password" class="span2" name="newpassword" placeholder="New Password" value="<?php check_string(Param::get('password')) ?>">
        <br>
        <li><?php echo "Confirm Password: "?></li>
        <input type="password" class="span2" name="cnewpassword" placeholder="Re-type Password" value="<?php check_string(Param::get('valdate_password')) ?>">
            <br>
    </ul>
    <input type="hidden" name="user_id" value="<?php check_string($user->id) ?>">
    <input type="hidden" name="page_next" value="write_success">
    <button type="submit" class="btn btn-inverse">Change Password</button>
</form>
