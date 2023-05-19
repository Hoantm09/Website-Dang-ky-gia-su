<?php 
class userModels extends ConnectDB{
    // Tạo dữ liệu mới
    function CreateUser($name,$email,$password){
        // Câu truy vấn
        $sql = "INSERT INTO `user`(
                    `name`,
                    `email`,
                    `password`
                )
                VALUES(
                    '$name',
                    '$email',
                    '$password'
                )";
        // Thực hiện truy vẫn
        mysqli_query($this->connection,$sql);
        // Kiểm tra xem có lỗi xảy ra không
        if (mysqli_error($this->connection) == ""){
            return true;
        }else{
            return false;
        }
    }
    // Hàm đăng nhập
    function loginUser($email,$password){
        // tìm kiếm dữ liệu qua email
        $user = $user = $this->selectOne('email', $email);

        // Kiểm tra xem dữ liệu có tồn tại hay không
        if (isset($user['password'])){
            // Kiểm tra mật khẩu
            $verify = password_verify($password, $user['password']);
            if ($verify){
                // Lưu phiên hay session
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['avatar'] = $user['avatar'];
                $_SESSION['lever'] = 1;
                return true;
            }  
        }else{
            return false;
        }
    }
   
}