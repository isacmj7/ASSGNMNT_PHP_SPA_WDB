<?php
    error_reporting(0);
    require_once('helper.php');

    if (isset($_GET["id"])) {
        $id = (int) $_GET["id"];
        $getfile = file_get_contents(DATA_FILE);
        $jsonfile = json_decode($getfile, true);
        $jsonfile = $jsonfile["users"];
        $jsonfile = $jsonfile["id_".$id];
    }

    if (isset($_POST["edit"]) && isset($_POST["id"])) {
        $id = (int) $_POST["id"];
        $getfile = file_get_contents(DATA_FILE);
        $all = json_decode($getfile, true);
        $jsonfile = $all["users"];
        $jsonfile = $jsonfile["id_".$id];
        
        $post = [];
        $post["id"] = isset($_POST["id"]) ? $_POST["id"] : $jsonfile["id"];
        $post["name"] = isset($_POST["uname"]) ? $_POST["uname"] : $jsonfile["name"];
        $post["address"] = isset($_POST["address"]) ? $_POST["address"] : $jsonfile["address"];
        $post["gender"] = isset($_POST["gender"]) ? $_POST["gender"] : $jsonfile["gender"];
        
        if ($jsonfile) {
            if(isset($_FILES['userimg']) && !empty($_FILES['userimg']['name'])) {
                $file_name = "user_img_".$id.'_'.time();
                $response = upload_image_file($_FILES['userimg'], $file_name);
                if($response['status'] === true) {
                    $post["image"] = $response['file_name'];
                    if(file_exists(IMG_ROOT.$jsonfile["image"])) {
                        unlink(IMG_ROOT.$jsonfile["image"]);
                    }
                    unset($all["users"]["id_".$id]);
                    $all["users"]["id_".$id] = $post;
                    file_put_contents(DATA_FILE, json_encode($all));
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
            } else {
                $post["image"] = $jsonfile["image"];
                unset($all["users"]["id_".$id]);
                $all["users"]["id_".$id] = $post;
                file_put_contents(DATA_FILE, json_encode($all));
            }
        }
        header("Location: ".BASE_URL."/index.php");
    }
    include('template/header.php');
?>
<?php if (isset($_GET["id"])): ?>
<div class="row d-flex justify-content-center align-items-center h-100">
    <form action="<?php echo BASE_URL; ?>/edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $id ?>" name="id"/>
        <div class="col-xl-9">
            <h1 class="text-white mb-4">Add User</h1>
            <div class="card" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row align-items-center pt-4 pb-3">
                        <div class="col-md-3 ps-5">
                            <h6 class="mb-0">Name</h6>
                        </div>
                        <div class="col-md-9 pe-5">
                            <input type="text" name="uname" placeholder="Enter Name" class="form-control form-control-lg" required="required" value="<?php echo $jsonfile["name"] ?>" />
                        </div>
                    </div>

                    <hr class="mx-n3">

                    <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
                            <h6 class="mb-0">Image</h6>
                        </div>
                        <div class="col-md-9 pe-5">
                            <img class="img" src="<?php echo IMG_ROOT . $jsonfile["image"]; ?>"></img>
                            <input class="form-control form-control-lg" name="userimg" type="file" />
                            <div class="small text-muted mt-2">Upload your Image file (.jpeg, .jpg, .png, .gif). Max file size 5 MB</div>
                        </div>
                    </div>

                    <hr class="mx-n3">

                    <div class="row align-items-center py-3">
                        <div class="col-md-3 ps-5">
                            <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-md-9 pe-5">
                            <textarea class="form-control" name="address" rows="3" placeholder="Enter Address" required="required"><?php echo $jsonfile["address"] ?></textarea>
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
                                value="Male" <?php if($jsonfile["gender"] == "Male") { ?> checked <?php } ?> />
                                <label class="form-check-label" for="maleGender">Male</label>
                            </div>
                            <div class="form-check form-check-inline mb-0 me-4">
                                <input class="form-check-input" type="radio" name="gender" id="femaleGender"
                                value="Female" <?php if($jsonfile["gender"] == "Female") { ?> checked <?php } ?> />
                                <label class="form-check-label" for="femaleGender">Female</label>
                            </div>
                        </div>
                    </div>

                    <hr class="mx-n3">

                    <div class="px-4 py-4">
                        <button type="submit" name="edit" class="btn btn-primary btn-lg">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php endif; ?>
<?php
    include('template/footer.php');
?>