<?
function ggPhAmounts() {
  global $setup;
  $ret='';
  $phlist = explode(",",$setup->phlist);
  $count = count($phlist);
  for ($i=0; $i < $count; $i++) {
      $amt = $phlist[$i] * $setup->exrate;
      $ret .= "<option value='$amt' ".($i==0? "selected":"").">$amt</option>";
  }
  return $ret;
}

function ggHelpCount($t) {
  global $user;
  $help = ggFetchValue("select count(id) from tblhelp where mem_id = $user->id and g_type='$t' and status<>'X'");
  return $help;
}

function ggPhDBox() {
    global $db, $setup, $user, $ls, $lang, $uid;

    $now = new datetime("now");
    $rs = $db->query("select * from tblhelpdetail where mem_id=$uid and g_type='P' order by id desc");
    while ($row = mysqli_fetch_object($rs)) {
        $class = ($row->g_type=='P')? 'table2_1':'table2_2';
        $oth = load_user($row->oth_id);
        $mem = load_user($uid);
        if ($row->stage == 2 || $row->stage == 4) {
          $time_remain = "";
        } else {
          $time_remain = ggTimeRemain($now,$row->g_timer);
        }
        echo "<table width='100%' class='$class'>";
        echo "<tr><td>".$ls->status[$lang]."</td><td>".$ls->match_code[$lang]."</td><td><? echo $ls->titleph[$lang]; ?></td><td></td><td>".$ls->ph_amount[$lang]."</td><td></td><td><? echo $ls->titlegh[$lang]; ?></td></tr>";

        $preview = "";
        if ($row->images<>"") {
          $preview = "<a href='$row->images' target='_blank'><img src='images/preview.jpg' width='25px' height='25px'></a>";
        }

        if ($row->stage<3) {
          $img = "star".($row->stage+1).".png";
        } else if ($row->stage==3) {
          $img = "question.png";
        } else {
          $img = "cross.png";
        }

        if ($row->g_type=='P') {
          echo "<tr><td><img src='images/$img' width=40 height=40></td><td>".ggAID($row->id)."<br>".substr($row->g_date,0,16)."<br><b class='red'>$time_remain</b></td><td width=100>$mem->username<br>$mem->fullname</td><td>-></td><td>$row->g_amount $setup->currency<br>$preview <button onclick='doDetail($row->id)' type='button' class='btn btn-success' data-toggle='modal' data-target='#myForm'>".$ls->detail[$lang]."</button></td><td>-></td><td width=100>$oth->username<br>$oth->fullname</td></tr>";
        } else {
          echo "<tr><td><img src='images/$img' width=40 height=40></td><td>".ggAID($row->id)."<br>".substr($row->g_date,0,16)."<br><b class='red'>$time_remain</b></td><td width=100>$oth->username<br>$oth->fullname</td><td>-></td><td>$row->g_amount $setup->currency<br>$preview <button onclick='doDetail($row->id)' type='button' class='btn btn-success' data-toggle='modal' data-target='#detailForm'>".$ls->detail[$lang]."</button></td><td>-></td><td width=100>$mem->username<br>$mem->fullname</td></tr>";
        }
        echo "</table><p style='height: 1px'></p>";
    }

}

function ggGhDBox() {
  global $db, $setup, $user, $lang, $ls,$uid;
    $now = new datetime("now");
    $rs = $db->query("select * from tblhelpdetail where mem_id=$uid and g_type='G' order by id desc");
    while ($row = mysqli_fetch_object($rs)) {
        $class = ($row->g_type=='P')? 'table2_1':'table2_2';
        $oth = load_user($row->oth_id);
        $mem = load_user($uid);
        if ($row->stage == 2 || $row->stage == 4) {
          $time_remain = "";
        } else {
          $time_remain = ggTimeRemain($now,$row->g_timer);
        }
        echo "<table width='100%' class='$class'>";
        echo "<tr><td>".$ls->status[$lang]."</td><td>".$ls->match_code[$lang]."</td><td><? echo $ls->titleph[$lang]; ?></td><td></td><td>".$ls->gh_amount[$lang]."</td><td></td><td><? echo $ls->titlegh[$lang]; ?></td></tr>";

        $preview = "";
        if ($row->images<>"") {
          $preview = "<a href='$row->images' target='_blank'><img src='images/preview.jpg' width='25px' height='25px'></a>";
        }

        if ($row->stage<3) {
          $img = "star".($row->stage+1).".png";
        } else if ($row->stage==3) {
          $img = "question.png";
        } else {
          $img = "cross.png";
        }

        if ($row->g_type=='P') {
          echo "<tr><td><img src='images/$img' width=40 height=40></td><td>".ggAID($row->id)."<br>".substr($row->g_date,0,16)."<br><b class='red'>$time_remain</b></td><td width=100>$mem->username<br>$mem->fullname<br>$mem->bankname</td><td>-></td><td>$row->g_amount $setup->currency<br>$preview <button onclick='doDetail($row->id)' type='button' class='btn btn-success' data-toggle='modal' data-target='#detailForm'>".$ls->detail[$lang]."</button></td><td>-></td><td width=100>$oth->username<br>$oth->fullname<br>$oth->bankname</td></tr>";
        } else {
          echo "<tr><td><img src='images/$img' width=40 height=40></td><td>".ggAID($row->id)."<br>".substr($row->g_date,0,16)."<br><b class='red'>$time_remain</b></td><td width=100>$oth->username<br>$oth->fullname<br>$oth->bankname</td><td>-></td><td>$row->g_amount $setup->currency<br>$preview <button onclick='doDetail($row->id)' type='button' class='btn btn-success' data-toggle='modal' data-target='#detailForm'>".$ls->detail[$lang]."</button></td><td>-></td><td width=100>$mem->username<br>$mem->fullname<br>$mem->bankname</td></tr>";
        }
        echo "</table><p style='height: 1px'></p>";
    }
    return $ret;
}

function ggPhBox() {
    global $db, $setup, $user, $ls, $lang, $uid;
    $ret = "";

    if ($rs = $db->query("select * from tblhelp where mem_id=$uid and g_type='P' and status<>'X' order by g_date desc")) {
    $now = new DateTime("NOW");
    while ($row = mysqli_fetch_object($rs)) {
      $class = ($row->g_type=='P')? 'table2_1':'table2_2';
      $g_date = new DateTime($row->g_date);
      $interval = $now->diff($g_date);
      $days = $interval->format("%d");

      if ($row->status=="X") {
         $color = 'silver';
         $status = $ls->cancelled[$lang];
      } else if ($row->status=="P") {
         $color = '#bcd979';
         $status = $ls->matching[$lang];
         $pending1 = $ls->w_matching[$lang]."<br>";
         $pending2 = number_format($row->g_pending)."  $setup->currency<br>";
      } else if ($row->status=="C") {
         $color = '#bcd979';
         $status = $ls->matched[$lang];
      } else if ($row->status=="D") {
         $color = '#bcd979';
         $status = $ls->completed[$lang];
      } else if ($row->status=="F") {
         $color = '#bcd979';
         $status = "<b class=red>".$ls->failed[$lang]."</b>";
      } else if ($row->status=="B") {
         $color = '#bcd979';
         $status = "<b class=red>".$ls->blocked[$lang]."</b>";
      } else {
         $color = '#bcd979';
         $status = $ls->waiting1[$lang].$days.$ls->waiting2[$lang];
      }
      $cancel = "";
      if ($row->status=="O" and $days < 7) {
          $cancel = "<br><a ref='#' class='btn btn-danger' onclick='doCancel($row->id)'>".$ls->cancel[$lang]."</a>";
      }
      // GG PHBox2
      $ret .= "<table width='100%' class=$class>";
      $uname = ggFetchValue("select username from tblmember where id = $row->mem_id");
      $ret .= "<tr bgcolor=green><td colspan=2 style='color: white; font-size:100%;'>".$ls->aph[$lang].": <br>".ggHID($row->id)."</td></tr>";
      $ret .= "<tr><td style='text-align:left; vertical-align:top;'>".$ls->participants[$lang].":<br>".$ls->ph_amount[$lang].":<br>$pending1 ".$ls->date[$lang].":<br>".$ls->status[$lang].":</td><td style='text-align:left; vertical-align:top;'>$uname<br>".number_format($row->g_amount)." $setup->currency<br>$pending2 ".substr($row->g_date,0,16)."<br>$status $cancel</td></tr>";
      $ret .= "</table><br>";
    }
  }
  return $ret;
}


function ggGhBox() {
  global $db, $setup, $user,$uid,$ls,$lang;
  $ret = "";

  if ($rs = $db->query("select * from tblhelp where mem_id=$uid and g_type='G' and status<>'X'")) {
    $now = new DateTime("NOW");
    while ($row = mysqli_fetch_object($rs)) {
      $class = ($row->g_type=='P')? 'table2_1':'table2_2';
      $g_date = new DateTime($row->g_date);
      $interval = $now->diff($g_date);
      $days = $interval->format("%d");

      $pending1="";
      $pending2 = "";
      if ($row->status=="X") {
         $color = 'silver';
         $status = $ls->cancelled[$lang];
      } else if ($row->status=="P") {
         $color = '#bcd979';
         $status = $ls->matching[$lang];
         $pending1 = $ls->w_matching[$lang]."<br>";
         $pending2 = number_format($row->g_pending)."  $setup->currency<br>";
      } else if ($row->status=="D") {
         $color = '#bcd979';
         $status = $ls->completed[$lang];
       } else if ($row->status=="C") {
         $color = '#bcd979';
         $status = $ls->matched[$lang];
      } else if ($row->status=="B") {
         $color = '#bcd979';
         $status = "<b class=red>".$ls->blocked[$lang]."</b>";
      } else {
         $color = '#bcd979';
         $status = $ls->waiting1[$lang].$days.$ls->waiting2[$lang];
      }

      $source1 = $ls->src_wallet[$lang].":<br>";
      if ($row->note == 'deposit') {
        $source2 = $ls->src_deposit[$lang]."<br>";
      } else if ($row->note == 'referral') {
        $source2 = $ls->src_sponsor[$lang]."<br>";
      } else if ($row->note == 'manager') {
        $source2 = $ls->src_manager[$lang]."<br>";
      } else {
        $source2 = $ls->src_special[$lang]."<br>";
      }

      $cancel = "";
      if ($row->status=="O" and $days < 7) {
          $cancel = "<br><a ref='#' class='btn btn-danger' onclick='doCancel($row->id)'>".$ls->cancel[$lang]."</a>";
      }
      // GG PHBox2
      $ret .= "<table width='100%' class=$class>";
      $uname = ggFetchValue("select username from tblmember where id = $row->mem_id");
      $ret .= "<tr bgcolor=green><td colspan=2 style='color: white; font-size:100%;'>".$ls->agh[$lang].": <br>".ggHID($row->id)."</td></tr>";
      $ret .= "<tr><td style='text-align:left; vertical-align:top;'>".$ls->participants[$lang].":<br>".$ls->gh_amount[$lang].":<br>$pending1 $source1 ".$ls->date[$lang].":<br>".$ls->status[$lang].":</td><td style='text-align:left; vertical-align:top;'>$uname<br>".number_format($row->g_amount)." $setup->currency<br>$pending2 $source2".substr($row->g_date,0,16)."<br>$status $cancel</td></tr>";
      $ret .= "</table><br>";
    }
  }
  return $ret;
}
?>