<?php
require_once('include/init.php');
$base::GetHeader();

if (isset($_POST['user'])) {
    $base->UserAdd($_POST['user']);
    echo '<script>parent.show("userlist");parent.$.fancybox.close();</script>';
}
?>
<style>
    body { padding: 10px; }
    input.error {box-shadow: 0px 0px 10px 0px rgb(209,0,0)}
</style>
<div id="adduser-main-container" class="flex" style="flex-direction: column">
    <div id="adduser-header-container">
        <span style="font-size: 28px">Add New User</span>
    </div>
    <div id="adduser-form-container" class="flex">
        <form id="form-adduser" action="" method="post" style="width: 100%; height: auto; margin-top: 15px;">
            <div class="input-container">
                <label for="type">Type:</label>
                <select id="type" name="user[u_type]">
                    <option value="user">User</option>
                    <option value="sv">Supervisor</option>
                </select>
            </div>
            <div class="input-container">
                <label for="firstname">First name:</label><input id="firstname" name="user[u_firstname]">
            </div>
            <div class="input-container">
                <label for="lastname">Last name:</label><input id="lastname" name="user[u_lastname]">
            </div>
            <div class="input-container">
                <label for="username">Username:</label><input id="username" name="user[u_username]" required>
            </div>
            <div class="input-container">
                <label for="email">E-Mail:</label><input id="email" name="user[u_email]">
            </div>
            <a href="#" onclick="$('#form-adduser').submit()">
                <div class="choc-button" style="margin-top: 25px;">
                    Save
                </div>
            </a>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#form-adduser').validate({
            messages: {
                "user[u_username]": "",
            },
            errorPlacement: function() {},
            highlight: function(element, errorClass) {
                $(element).addClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            }
        });

        $('#username').on("focus", function() {
            if ($(this).val() === '') {
                $.ajax({
                    url: "include/ajax/proc.php",
                    type: "POST",
                    data: {
                        type: "adduser_generate_username",
                        firstname: $('#firstname').val(),
                        lastname: $('#lastname').val(),
                    }
                }).done(function (feedback) {
                    $('#username').val(feedback);
                    $("#email").focus();
                });
            }
        })
    });
</script>