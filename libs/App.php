<?php require (__DIR__ ."/../config/config.php"); ?>

<?php
    class App {
        public $host = HOST;
        public $dbname = DBNAME;
        public $user = USER;
        public $pass = PASS;
        

        public $pdo;


        //create a construct

        public function __construct() {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }


        public function connect() {
            $this->pdo = new PDO("mysql:host=$this->host; mdbname=$this->dbname", $this->user, $this->pass);

            // if($this->link) {
            //     echo "Connected";
            // } else {
            //     echo "Not Connected";
            // }
        }

        //selecta all

        public function selectAll($query, $params = []) {
            try {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }

        public function selectOne($query, $params = []) {
            try {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                return $stmt->fetch(PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }

        public function validateCart($q) {
            $rows = $this->pdo->query($q);
            $rows->execute();
            $count = $rows->rowCount();
            return $count;
        }


        //insert query
        public function insert($query, $arr, $path) {
            if($this->validate($arr) == "empty"){
                echo "<script>alert('one or more inputs are empty')</script>";
            }else{
                $insest_record = $this->pdo->prepare($query);
                $insest_record->execute($arr);

                echo "<script>window.location.href='".$path."'</script>";
            }
        }


        //update query
        public function update($query, $arr, $path) {
            if($this->validate($arr) == "empty"){
                echo "<script>alert('one or more inputs are empty')</script>";
            }else{
                $update_record = $this->pdo->prepare($query);
                $update_record->execute($arr);

                header("location: ".$path."");
            }
        }


        //delete query
        public function delete($query, $path) {
            $delete_record = $this->pdo->query($query);
            $delete_record->execute();

            echo "<script>window.location.href='".$path."'</script>";
            
        }

        public function validate($arr){
            if(in_array("", $arr)){
                echo "empty";
            }
        }



        public function register($query, $arr, $path) {
            try {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($arr);
                echo "<script>window.location.href='".$path."'</script>" ;
                exit();
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }



        
        public function loginUser($query, $data, $path) {
            try {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':email' => $data[':email']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
                if ($user && password_verify($data[':password'], $user['password'])) {
                    // Lưu session riêng cho user
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['username'] = $user['username'];
                
                    // Chuyển hướng đến trang user
                    echo "<script>window.location.href='" . $path . "'</script>";
                    exit();
                } else {
                    echo "<script>alert('Email hoặc mật khẩu không đúng.');</script>";
                }
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }


        
        public function loginAdmin($query, $data, $path) {
    try {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $data[':email']]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($data[':password'], $admin['password'])) {
            $_SESSION['admin_name'] = $admin['admin_name'];
            $_SESSION['email'] = $admin['email']; // dùng tên riêng biệt

            echo "<script>window.location.href='".$path."'</script>";
            exit();
        } else {
            echo "Invalid email or password";
        }
    } catch (PDOException $e) {
        throw new Exception("Database error: " . $e->getMessage());
    }
}
    


        //starting session
        public function startingSession() {
            session_start();
        }

        //validating sessions
        public function validateSession() {
            if(isset($_SESSION["user_id"])) {
                echo "<script>window.location.href='".APPURL."'</script>";
            } 
        }

        public function validateSessionAdmin() {
            if(isset($_SESSION["email"])) {
                echo "<script>window.location.href='".ADMINURL."/index.php'</script>";
            } 
        }

        public function validateSessionAdminInside() {
            if(!isset($_SESSION["email"])) {
                echo "<script>window.location.href='".ADMINURL."/admin/login_admin.php'</script>";
            } 
        }
    


    public function insertAndGetId($query, $params = []) {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute($params);
    return $this->pdo->lastInsertId();
    }
}

