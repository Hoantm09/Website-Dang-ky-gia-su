<?php 
class tutor extends Controllers{
    // Kiểm tra đăng nhập
    public function checkLogin(){
        // Kiểm tra xem trong session có tồn tại phiên đăng nhập không
        if (isset($_SESSION['lever']) == false){
            return false;
        }
        // Kiểm tra cấp
        if ($_SESSION['lever'] == 2){
            return true;
        }
        return false;
    }
    // hàm hiển thị phần login
    public function login(){
        $this->view("tutor","tutor/login","Đăng nhập",[]);
    }
    // hàm hiển thị phần register
    public function register(){
        $this->view("tutor","tutor/register","Đăng kí",[]);
    }
    // Hiển thị phần tài khoản của tôi
    public function my_account(){
        if ($this->checkLogin() == false){
            $actual_link = $this->getUrl();
            header("Location: $actual_link/tutor/login");
        }
        $model = $this->model('giaSuModels');
        $myAccount = $model->selectOne('id',$_SESSION['id']);
        $this->view("tutor","tutor/myAccount","Tài khoản của tôi",[
            'email'         => $myAccount['email'],
            'phone_number'  => $myAccount['phone_number'],
            'gender'        => $myAccount['gender'],
            'address'       => $myAccount['address'],
            'description'   => $myAccount['description'], 
            'school_level'  => $myAccount['school_level'],
            'subject'       => $myAccount['subject']
        ]);
    }
    // Hiên Thị đổi mật khẩu
    public function change_password(){
        if ($this->checkLogin() == false){
            $actual_link = $this->getUrl();
            header("Location: $actual_link/tutor/login");
        }else{
            $this->view("tutor","editPassword","Đổi mật khẩu",[]);
        }
    }
    // Sử lý đổi mật khẩu
    public function change_password_processing(){
        $password   = addslashes($_POST['old_pass']);
        $new_pass   = addslashes($_POST['new_pass']);
        $secure_pass = password_hash($new_pass, PASSWORD_BCRYPT);
        $save = $this->model("giaSuModels");
        $actual_link = $this->getUrl();
        if ($save->ChangePass($password,$secure_pass)){
            $_SESSION['done'] = "Đổi mk thành công";
            header("Location: $actual_link/tutor/my_account");
        }else{
            $_SESSION['error'] = "Mật khẩu cũ không đúng";
            header("Location: $actual_link/tutor/change_password");
        }
    }
    // xử lý đằng kí
    public function register_processing(){
        // Nhận dữ liệu gửi lên
        $name = addslashes($_POST["name"]);
        $email = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);

        // Mã hóa mật khẩu
        $secure_pass = password_hash($password, PASSWORD_BCRYPT);

        // Gọi model
        $save = $this->model("giaSuModels");
        $actual_link = $this->getUrl();
        
        // Gọi hàm Tạo tài khoản và kiểm tra
        if ($save->CreateUser($name,$email,$secure_pass)){
            $_SESSION['success'] = "Đăng kí tài khoản thành công, vui lòng đăng nhập";
            header("Location: $actual_link/tutor/login");
        }else{
            $_SESSION['error'] = "Email này đã được sử dụng, vui lòng đăng kí lại";
            header("Location: $actual_link/tutor/register");
        }
    }
}