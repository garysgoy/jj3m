<?include("_dbconfig.php");include("_ggFunctions.php");//include("_sms.php");$lang=0;$ls = new stdClass();$ls->sorry = array("Sorry, there was an error uploading your file.","抱歉： 档案上载未能完成","抱歉： 檔案上載未能完成");$ls->reward1 = array("Congratulation: You have earn a bonus of", "恭喜你： 你获得诚信奖励：","恭喜你： 你獲得诚信獎勵：");$ls->reward2 = array("Sorry: You have a penalty of", "抱歉： 你迟打款被罚了","抱歉： 你遲打款被罰了");$msg = '';$time = time();$target_dir = "uploads/" . date("Y",$time).date("m",$time) ."/";$target_file = $target_dir . basename($_FILES["imgFile"]["name"]);$help_id = $_REQUEST['help_id'];$uploadOk = 1;$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);$save_file = $target_dir .$time . ".". $imageFileType;// Check if image file is a actual image or fake imageif(isset($_REQUEST["imgFile"])) {    $check = getimagesize($_FILES["imgFile"]["tmp_name"]);    if($check !== false) {        $uploadOk = 1;    } else {        $msg = "<br>File is not an image.";        $uploadOk = 0;    }}// Check if file already existsif (file_exists($target_file)) {    $msg = "<br>Sorry, file already exists.";    $uploadOk = 0;}// Check file sizeif ($_FILES["imgFile"]["size"] > 500000) {    $msg = "<br>Sorry, your file is too large.";    $uploadOk = 0;}// Allow certain file formatsif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {    $msg = "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";    $uploadOk = 0;}// Check if $uploadOk is set to 0 by an errorif ($uploadOk == 0) {    $msg .= "<br>Sorry, your file was not uploaded.";    echo json_encode(array('status'=>'fail','msg'=>$msg));} else {    if (move_uploaded_file($_FILES["imgFile"]["tmp_name"], $save_file)) {        $now = new DateTime("NOW");        $tran = ggFetchObject("select * from tblhelpdetail where id = $help_id");        $future_date = new DateTime($tran->g_timer);        $s_future_date = ggDateToString($future_date);        $interval = $now->diff($future_date);        $hours = $interval->format("%d") * 24 + $interval->format("%h");        $incentive = 0;/*        if ($tran->status=="0") {            if ($hours >= 32) {                $incentive = 1.3;            } else if ($hours>=24) {                $incentive = 1;            }        } else {            $incentive = 0; // Panelty        }*/        if ($incentive > 0) {            $inct = "<b class='green'>".$ls->reward1[$lang] ." ". $incentive."%</b>";        } else if ($incentive < 0) {            $inct = "<b class='red'>".$ls->reward2[$lang] ." ". $incentive."%</b>";        } else {            $inct = "";        }        $s_now = ggDateToString($now);        $timer = ggAddHours($now,24);        $s_timer = ggDateToString($timer);        $rs = $db->query("update tblhelpdetail set stage = 1, images ='$save_file',g_timer = '$s_timer', g_payment=Now() where tran_id = $tran->tran_id") or die ("update tran id ".$db->error);        $rs1 = $db->query("update tblmavro set incentive = $incentive where help_id = $tran->help_id and op_type='B'") or die ("update tran id ".$db->error);        $test = ggFetchObject("select stage from tblhelpdetail where tran_id = $tran->tran_id");        if ($test->stage < 1) {            $myfile = fopen("upload_err.txt", "w") or die(json_encode(array("nsg"=>"Unable to open file!")));            $txt = "interval = " . $interval->format("%d day %h hour %i min ");            fwrite($myfile, $txt);            $txt = "Future = $s_future_date \n";            fwrite($myfile, $txt);            $txt = "now = $s_now \n";            fwrite($myfile, $txt);            $txt = "hours = $hours \n";            fwrite($myfile, $txt);            $txt = "$save_file\n";            fwrite($myfile, $txt);            fclose($myfile);            $rs = $db->query("update tblhelpdetail set stage = 1, images ='".$save_file."',g_timer = '".$s_timer."', g_payment=Now() where tran_id = $tran->tran_id") or die ("update tran id ".$db->error);        }        // Save file name        //sms_gh($tran->tran_id);        echo json_encode(array('status'=>"success",'msg'=>"$inct"));    } else {        echo json_encode(array('status'=>'fail','msg'=>$ls->sorry[$lang]));    }}?>