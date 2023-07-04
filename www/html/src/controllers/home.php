<?php
class home extends Controllers{
    // Hiển thị phần home
    public function read(){
        $this->view("user","user/home","Trang chủ",[]);
    }
    // Hiển thị phần blog khách hàng
    public function user_blog($route = []){
        // Sử lý phần tìm kiếm
        $search = "";
        if (isset($_GET['search'])){
            $search = $_GET['search'];
        }
        $model = $this->model('blogModels');
        $blogs = $model->selectValues(1,$search);
        $this->view("user","user/Blog","blog khách hàng 1",[$search, $blogs]);
    }
    // Hiển thị phần blog gia sư
    public function tutor_blog($route = []){
        // Sử lý phần tìm kiếm
        $search = "";
        if (isset($_GET['search'])){
            $search = $_GET['search'];
        }
        $model = $this->model('blogModels');
        $blogs = $model->selectValues(2,$search);
        $this->view("user","tutor/Blog","blog gia sư",[$search, $blogs]);
    }
    // Xem blog chi tiết
    public function view_blog($route = []){
        $model = $this->model('blogModels');
        $blog = $model->selectById($route[0]);
        $this->view("user","user/viewBlog",$blog["title"],$blog);
    }
    // Hàm tạo blog
    public function create_blog(){
        // Kiểm tra đăng nhập
        if (isset($_SESSION['lever'])){
            $this->view("user","createBlog","Viết Blog",[]);
        }else{
            $actual_link = $this->getUrl();
            $_SESSION['error'] = "Bạn phải đăng nhập để tạo blog";
            header("Location: $actual_link/tutor/login");
        }
    }
   
}
?>