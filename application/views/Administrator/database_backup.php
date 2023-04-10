<?php
if (isset($_POST['submit'])) {
    $CI = &get_instance();
    $CI->load->dbutil();

    $prefs = array(
        'format' => 'zip',
        'filename' => 'my_db_backup.sql'
    );

    $backup = &$CI->dbutil->backup($prefs);

    $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
    $save = 'pathtobkfolder/' . $db_name;

    $CI->load->helper('file');
    write_file($save, $backup);

    $CI->load->helper('download');
    force_download($db_name, $backup);
}
?>
<style>
    .backup-button div {
        width:250px;height:120px;background:lightgreen;padding:25px;font-size:20px;color:#454545
    }
    .backup-button div:hover {
        background: lightblue;
    }
</style>
<div class="row">
    <div class="col-md-12 text-center">
        <form action="" method="post" style="margin-top:15%;">
            <button type="submit" name="submit" class="backup-button btn btn-success" style="border:none;padding:0px;">
                <div>
                    <i class="fa fa-database fa-2x"></i><br>
                    Backup Now</div>
            </button>
        </form>
    </div>
</div>