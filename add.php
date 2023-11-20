<?php
    include('common.php');
    $auto_increment_id = (isset($json_data) && !empty($json_data->auto_increment_id)) ? $json_data->auto_increment_id : 1;

    require_once('helper.php');

    if (isset($_POST["add"])) {
        $data = $post_data = [];
        if(file_exists(DATA_FILE)) {
            $get_file = file_get_contents(DATA_FILE);
            $data = json_decode($get_file, true);
        }
        unset($_POST["add"]);
        $data["users"] = array_key_exists('users', $data) ? $data["users"] : [];
        $data["auto_increment_id"] = $auto_increment_id + 1;
        $post_data["id"] = $auto_increment_id;
        $post_data["name"] = $_POST["uname"];
        $file_name = "user_img_".$post_data["id"]."_".time();
        $response = upload_image_file($_FILES['userimg'], $file_name);
        if($response['status'] === true) {
            $post_data["image"] = $response['file_name'];
            $post_data["address"] = $_POST["address"];
            $post_data["gender"] = $_POST["gender"];
            $data["users"]["id_".$auto_increment_id] = $post_data;
            file_put_contents(DATA_FILE, json_encode($data));
            header("Location: ".BASE_URL."/index.php");
        } else {
            echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Error</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        '.$response['error_msg'].'
                    </div>
                </div>
            </div>';
        }
    }
    include('template/header.php');
?>
<div class="row d-flex justify-content-center align-items-center h-100">
    <form action="<?php echo BASE_URL; ?>/add.php" method="POST" enctype="multipart/form-data">
        <div class="col-xl-9">
            <h1 class="text-white mb-4">Add User</h1>
            <div class="card" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row align-items-center pt-4 pb-3">
                        <div class="col-md-3 ps-5">
                            <h6 class="mb-0">Name</h6>
                        </div>
                        <div class="col-md-9 pe-5">
                            <input type="text" name="uname" placeholder="Enter Name" class="form-control form-control-lg" required="required" />
                        </div>
                    </div>

                    <hr class="mx-n3">

                    <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
                            <h6 class="mb-0">Image</h6>
                        </div>
                        <div class="col-md-9 pe-5">
                            <input class="form-control form-control-lg" name="userimg" type="file" required="required" />
                            <div class="small text-muted mt-2">Upload your Image file (.jpeg, .jpg, .png, .gif). Max file size 5 MB</div>
                        </div>
                    </div>

                    <hr class="mx-n3">

                    <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
                            <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-md-9 pe-5">
                            <textarea class="form-control" name="address" rows="3" placeholder="Enter Address" required="required"></textarea>
                        </div>
                    </div>

                    <hr class="mx-n3">

                    <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
                            <h6 class="mb-0">Gender</h6>
                        </div>
                        <div class="col-md-9 pe-5">
                            <div class="form-check form-check-inline mb-0 me-4">
                                <input class="form-check-input" type="radio" name="gender" id="maleGender"
                                value="Male" />
                                <label class="form-check-label" for="maleGender">Male</label>
                            </div>
                            <div class="form-check form-check-inline mb-0 me-4">
                                <input class="form-check-input" type="radio" name="gender" id="femaleGender"
                                value="Female" />
                                <label class="form-check-label" for="femaleGender">Female</label>
                            </div>
                        </div>
                    </div>

                    <hr class="mx-n3">

                    <div class="px-4 py-4">
                        <button type="submit" name="add" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
    include('template/footer.php');
?>