<?php 
class giaSuModels extends ConnectDB{
    // Tạo dữ liệu mới
    function CreateUser($name,$email,$password){
        // Câu truy vấn
        $sql = "INSERT INTO `instructor`(
                    `name`,
                    `email`,
                    `password`
                )
                VALUES(
                    '$name',
                    '$email',
                    '$password'
                )";
        // Thực hiện truye vấn và kiểm tra
        mysqli_query($this->connection,$sql);
        if (mysqli_error($this->connection) == ""){
            return true;
        }else{
            return false;
        }
    }