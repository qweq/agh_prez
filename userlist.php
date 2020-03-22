<?php

?>
<style>
    #userlist-main-container {
        flex-direction: column;
        width: 100%;
        height: 100%;
    }

    #userlist-header-container {
        width: 100%;
        height: 15%;
        justify-content: space-between;
        align-items: center;
    }

    #userlist-table-container {
        margin-top: 30px;
    }

    .bottom {
        margin-top: 20px;
    }

    .bottom-left {
        float: left;
    }
</style>
<div id="userlist-main-container" class="flex">
    <div id="userlist-header-container" class="flex">
        <div style="height: auto">
            <span style="font-size: 28px;">User List</span>
        </div>
        <a href="adduser.php" data-fancybox>
            <div class="choc-button">
                <span style="font-size: 16px; color: white">Add New</span>
            </div>
        </a>
    </div>
    <div id="userlist-table-container">
        <table id="userlist-table" class="dataTable">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Username</td>
                    <td>First name</td>
                    <td>Last name</td>
                    <td>E-Mail</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php $sql = "SELECT * FROM ".$base::db.".user WHERE 1";
                $result = $mysqli->query($sql);
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?=$row['u_id']?></td>
                        <td><?=$row['u_username']?></td>
                        <td><?=$row['u_firstname']?></td>
                        <td><?=$row['u_lastname']?></td>
                        <td><?=$row['u_email']?></td>
                        <td>X</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#userlist-table').dataTable({
            "dom": 't<"bottom"<"bottom-left"f><"bottom-right"p>>',
            "columns": [
                null,
                null,
                null,
                null,
                null,
                {"sortable": false},
            ]
        });

        $('[data-fancybox]').fancybox({
            type: 'iframe',
            buttons: ['close'],
            iframe: {
                'preload': false,
                'css': {
                    height: '410px',
                    width: '500px',
                },
                attr: {},
            },
            animationEffect: 'fade',

        });
    });
</script>
