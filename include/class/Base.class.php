<?php

class Base {
    private $u_id;
    private $user_level;
    private $mysqli;
    private $login_error;
    const db = DB_NAME;
    const main_color = '#d2691e';
    const hover_color = '#f78123';


    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function Login($username, $password) {
        $sql = "SELECT * FROM ".$this::db.".user WHERE u_username = '".$this->mysqli->res($username)."'";
        $urow = $this->mysqli->Row($sql);
        if (!empty($urow)) {
            $success = password_verify($password, $urow['u_password']);

            if ($success) {
                $this->Session($urow);
                $this->u_id = $urow['u_id'];
                $this->user_level = $urow['u_type'];
                $l_id = $this->TraceLogin();
                $_SESSION['user']['login']['l_id'] = $l_id;
                return true;
            }
            else
                $this->login_error = 'wrongpwd';
                $this->mysqli->InsertRow('agh', 'login_failed', array('lf_u_id' => $urow['u_id'], 'lf_ip' => $_SERVER['REMOTE_ADDR'], 'lf_useragent' => $_SERVER['HTTP_USER_AGENT'], 'lf_reason' => $this->login_error, 'lf_timestamp' => 'NOW()'));{
                $this->Logout();
                return false;
            }
        }
        else {
            $this->login_error = 'nouser';
            $this->mysqli->InsertRow('agh', 'login_failed', array('lf_ip' => $_SERVER['REMOTE_ADDR'], 'lf_useragent' => $_SERVER['HTTP_USER_AGENT'], 'lf_reason' => $this->login_error, 'lf_timestamp' => 'NOW()'));
            return false;
        }
    }

    function Session($user_array) {
        $_SESSION['user'] = array(
            'u_id' => $user_array['u_id'],
            'type' => $user_array['u_type'],
            'firstname' => $user_array['u_firstname'],
            'lastname' => $user_array['u_lastname'],
        );
    }

    function TraceLogin() {
        return $this->mysqli->InsertRow('agh', 'login', array('l_u_id' => $this->u_id, 'l_ip' => $_SERVER['REMOTE_ADDR'], 'l_useragent' => $_SERVER['HTTP_USER_AGENT'], 'l_timestamp' => 'NOW()'));
    }

    public function Logout() {
        if (isset($_SESSION['user']['login']['l_id'])) {
            $l_id = $_SESSION['user']['login']['l_id'];
            $this->mysqli->UpdateRow('agh', 'login', $l_id, array('l_logout' => 'NOW()'));
        }

        $this->u_id = null;
        $this->user_level = null;
        unset($_SESSION['user']);
        session_destroy();
    }

    public function GetLoginError() {
        return $this->login_error;
    }

    public function GetUserLevel() {
        if ($this->user_level == 'admin') return 'a';
        else if ($this->user_level == 'sv') return 's';
        else return 'u';
    }

    public static function GetHeader() {
        echo '
            <link rel="stylesheet" href="/css/style.css">
            <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;400;500;700&display=swap" rel="stylesheet">
            <script type="text/javascript" src="include/javascript/jquery/jquery-3.4.1.min.js"></script>
            <link rel="stylesheet" type="text/css" href="include/javascript/jquery/DataTables/datatables.min.css"/>
            <script type="text/javascript" src="include/javascript/jquery/DataTables/datatables.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
            <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
        ';
    }

    public function UserAdd($user_array) {
        if (!is_array($user_array)) return false;

        if (!isset($user_array['u_username']) || $user_array['u_username'] === '') return false;
        if (!isset($user_array['u_type'])) $user_array['u_type'] = 'user';

        return $this->mysqli->InsertRow($this::db, 'user', $user_array);
    }

    public function UserEdit($u_id, $user_array) {
        if (!is_array($user_array)) return false;

        if (isset($user_array['u_password'])) $user_array['u_password'] = password_hash($user_array['u_password'], 1);

        return $this->mysqli->UpdateRow($this::db, 'user', $u_id, $user_array);
    }
}