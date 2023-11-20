<?php
error_reporting(0);
require_once('config.php');

function array_orderby() {
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
        }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

if (isset($_POST["sort_type"]) && isset($_POST["sort_column"])) {
    $getfile = file_get_contents(DATA_FILE);
    $jsonfile = json_decode($getfile, true);
    $jsonfile = $jsonfile["users"];
    $sort_type_arr = ['asc' => SORT_ASC, 'desc' => SORT_DESC];
    $sorted_data = array_orderby($jsonfile, $_POST["sort_column"], $sort_type_arr[$_POST["sort_type"]]);
}
?>
<tbody id="user-tbody">
    <?php 
        if(!empty($sorted_data) && count($sorted_data) > 0) {
            foreach ($sorted_data as $index => $row):
    ?>
            <tr class="clearfix">
                <td class="col-md-1"><?php echo $row['id']; ?></td>
                <td class="col-md-2"><?php echo $row['name']; ?></td>
                <td class="col-md-2">
                    <img class="img" src="<?php echo IMG_ROOT . $row['image']; ?>"></img>
                    <img class="icon" src="<?php echo IMG_ROOT; ?>arrow-down-circle-fill.svg" onclick="downloadUserImage('<?php echo $row['id']; ?>', '<?php echo BASE_URL; ?>/download.php?id=<?php echo $row['id']; ?>');"></img>
                </td>
                <td class="col-md-3"><?php echo $row['address']; ?></td>
                <td class="col-md-1"><?php echo $row['gender']; ?></td>
                <td class="col-md-3">
                    <a rel="button" class="btn btn-secondary" href="<?php echo BASE_URL; ?>/edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a rel="button" class="btn btn-danger" href="<?php echo BASE_URL; ?>/delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                    <a rel="button" class="btn btn-primary" href="<?php echo BASE_URL; ?>/view.php?id=<?php echo $row['id']; ?>">View</a>
                </td>
            </tr>
    <?php 
            endforeach; 
        } else {
    ?>
        <tr class="clearfix"><td colspan="6" class="col-md-12">No data found</td></tr>
    <?php } ?>
</tbody>