<?php

class DB
{
    public static $conn;

    function __construct()
    {
        if (!isset(self::$conn)) {
            $conn_string = "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST = dbs.cs.hacettepe.edu.tr)(PORT = 1521))	(CONNECT_DATA =(SID =  dbs)))";
            self::$conn = oci_connect("C##b21327771", "21327771", $conn_string);
            if (!self::$conn) {
                $m = oci_error();
                echo $m['message'], "\n";
                exit;
            }
        }
    }

    function login($username, $password)
    {
        $sql = " SELECT * FROM USERTBL WHERE username = :username AND user_password = :user_password ";
        $stmt = oci_parse(self::$conn, $sql);
        oci_bind_by_name($stmt, ":username", $username);
        oci_bind_by_name($stmt, ":user_password", $password);
        oci_execute($stmt);


        if ($user = oci_fetch_array($stmt, OCI_ASSOC)) {
            $_SESSION["login"] = "true";
            $_SESSION["user"] = $user['USERID'];
            $_SESSION["username"] = $user['USERNAME'];
            $_SESSION["password"] = $password;
            $_SESSION["firstname"] = $user['FIRST_NAME'];
            $_SESSION["lastname"] = $user['SURNAME'];

            list($isadmin, $tmp) = $this->selectById('SYSTEMUSER', 'USERID', $user['USERID']);
            $_SESSION["admin"] = $isadmin > 0 ? true : false;

            return "login:success";

        } else {
            if ($username == "" or $password == "") {
                return "login:error1";
            } else {
                return "login:error2";
            }
        }
    }

    function executeProcedure($parameters, $procedure_name)
    {
        $sql = 'CALL ' . $procedure_name . '(';

        for ($i = 0; $i < count($parameters); $i++) {
            $sql .= ':param' . $i;
            if ($i != count($parameters) - 1) {
                $sql .= ', ';
            } else {
                $sql .= ') ';
            }
        }

        $stmt = oci_parse(self::$conn, $sql);
        for ($i = 0; $i < count($parameters); $i++) {
            oci_bind_by_name($stmt, ':param' . $i, $parameters[$i]);
        }

        return @oci_execute($stmt);
    }

    function selectAll($view_name)
    {
        $sql = " SELECT * FROM " . $view_name;
        $stmt = oci_parse(self::$conn, $sql);

        oci_execute($stmt);
        $n_rows = oci_fetch_all($stmt, $result);
        return array($n_rows, $result);
    }

    function selectById($view_name, $where, $id)
    {
        $sql = " SELECT * FROM " . $view_name . " WHERE " . $where . " = " . $id;
        $stmt = oci_parse(self::$conn, $sql);

        @oci_execute($stmt);
        @$n_rows = oci_fetch_all($stmt, $result);
        return array($n_rows, $result);
    }

    function selectFirstRow($view_name)
    {
        $sql = " SELECT * FROM " . $view_name . " FETCH FIRST 1 ROWS ONLY";
        $stmt = oci_parse(self::$conn, $sql);

        @oci_execute($stmt);
        @$n_rows = oci_fetch_all($stmt, $result);
        return array($n_rows, $result);
    }

    function executeQuery($query)
    {
        $stmt = oci_parse(self::$conn, $query);

        oci_execute($stmt);
        $n_rows = oci_fetch_all($stmt, $result);
        return array($n_rows, $result);
    }
}









// Close the Oracle connection
//oci_close($conn);