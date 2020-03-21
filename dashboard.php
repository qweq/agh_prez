<?php

?>
<style>
    .opaque {
        background-color: white;
    }

    .flex {
        display: flex;
    }

    .shadow {
        border: 3px solid rgb(188,188,188);
    }

    #main-dashboard-container {
        height: 100%;
    }

    #middle-dashboard-container {
        width: 1100px;
        height: 90%;
        margin: auto;
        flex-direction: column;
    }

    #header-dashboard-container {
        width: 100%;
        height: 100px;
        padding: 10px;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    #header-dashboard-container div {
        height: auto;
    }

    #content-dashboard-container {
        width: 100%;
        height: calc(100% - 100px);
    }

    #menu-container {
        width: 20%;
        flex-direction: column;
        align-items: center;
        margin-right: 25px;
    }

    #content-container {
        width: 80%;
        padding: 20px;
    }

    .menu-div {
        height: 55px;
        width: 90%;
        border-bottom: 1px solid #cccccc;
        text-align: center;
        line-height: 55px;
    }

    #menu-container div.menu-div:last-child {
        border-bottom: none;
    }
</style>
<div id="main-dashboard-container" class="flex">
    <div id="middle-dashboard-container" class="flex">
        <div id="header-dashboard-container" class="flex opaque shadow">
            <div>
                <span style="font-size: 24px; font-weight: bold">AGH-UNESCO</span>
            </div>
            <div>
                <span style="font-size: 18px; font-weight: bolder"><?=$_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname']?></span>
                <br><a href="login.php?logout" style="float: right">Log out</a>
            </div>
        </div>
        <div id="content-dashboard-container" class="flex">
            <div id="menu-container" class="flex opaque shadow">
                <div class="menu-div">
                    <a href="#" onclick="show('userlist')">User List</a>
                </div>
                <div class="menu-div">
                    <a href="#" onclick="show('uploadlist')">Upload List</a>
                </div>
                <div class="menu-div">
                    <a href="#" onclick="show('myuploads')">My Uploads</a>
                </div>
            </div>
            <div id="content-container" class="opaque shadow">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        show('userlist');
    });


    function show(type) {
        let result = $.ajax({
            url: '/include/ajax/view.php',
            data: {
                type: type,
            },
            type: 'POST',
        });

        result.done(function (feedback) {
            $('#content-container').html(feedback);
        });

        result.fail(function (value) {
            alert('eror!');
        })
    }
</script>