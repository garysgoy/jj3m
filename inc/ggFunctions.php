<?

function ggAddDays($date1,$days) {
	$date1->Modify("+$days Days");
	return ($date1);
}
function ggAddHours($date1,$hours) {
	$date1->Modify("+$hours Hours");
	return ($date1);
}

function ggDaysDiff($date1, $date2 = null) {
	if ($date2 == null) $date2 = new DateTime("Now");
	$days = round(($date2->format('U') - $date1->format('U')) / (60*60*24));
	return ($days);
}

function ggHoursDiff($date1, $date2 = null) {
	if ($date2 == null) $date2 = new DateTime("Now");
	$hours = round(($date2->format('U') - $date1->format('U')) / (60*60));
	return ($hours);
}

function ggDateToString($date) {
	return ($date->format('Y-m-d H:i:s'));
}

function ggNow() {
	$now = new DateTime("now");
	//$now->Modify("+12 Hours");
	return ($now);
}

function ggNows() {
  $time1 = date('Y-m-d H:i:s',time());
	//$now->Modify("+12 Hours");
	return $time1;
}

function ggGetMemberName($mem_id) {
  global $db;
	$rs = $db->query("select username from tblmember where user_id = $mem_id") or die($db->error);
	if (mysqli_num_rows($rs) > 0) {
		$row = mysqli_fetch_array($rs);
		$name = $row[0];
	} else {
		$name = "";
	}
	return ($name);
}

function ggFetchValue($q) {
  global $db;
	$rs = $db->query($q) or die($db->error);
	if (mysqli_num_rows($rs) > 0) {
		$row = mysqli_fetch_array($rs);
		$ret = $row[0];
	} else {
		$ret = "";
	}
	return ($ret);
}

function ggGetMemberID($username) {
  global $db;
	$rs = $db->query("select id from tblmember where username = '$username'") or die($db->error);
	if (mysqli_num_rows($rs) > 0) {
		$row = mysqli_fetch_array($rs);
		$id = $row[0];
	} else {
		$id = 0;
	}
	return ($id);
}

function ggFetchArray($sql) {
  global $db;
	$ret = "";
	$rs = $db->query($sql);
	if (mysqli_num_rows($rs) > 0) {
		$ret = mysqli_fetch_array($rs);
	}
	return ($ret);
}

function ggFetchObject($sql) {
  global $db;
	$ret = "";
	$rs = $db->query($sql);
	if ($rs && mysqli_num_rows($rs) > 0) {
		$ret = mysqli_fetch_object($rs);
	}
	return ($ret);
}

function ggHID($id) {
	$ret = "H" . (1500000 + $id);
	return ($ret);
}

function ggRID($id) {
	$ret = "R" . (3500000 + $id);
	return ($ret);
}

function ggAID($id) {
	$ret = "A" . (2500000 + $id);
	return ($ret);
}

function ggInterestDays($create, $release) {
    $date = new datetime($create);
    if ($release == "0000-00-00 00:00:00") {
	    $days = ggDaysDiff($date);
    } else {
        $date2 = new datetime($release);
	    $days = ggDaysDiff($date,$date2);
    }
    return ($days);
}

function ggAccessLog1($username, $type, $note) {
  global $db;
	$now = ggNows();

	$tt = $db->query("insert into tblaccesslog1 (username, l_type, l_note, l_date) values ('$username','$type','$note','$now')");
}

function ggRank($rank,$type) {
  global $lang;
  $ls = new stdClass();
  $ls->rank1 = array("Member","普通会员","普通會員");
  $ls->rank5 = array("Manager","注册经理","註冊經理");
  $ls->rank6 = array("Senior Manager","合格经理","合格經理");
  $ls->rank7 = array("Top Manager","高级经理","高級經理");
	if ($rank==5) {
		$ret = $ls->rank5[$lang];
	} else if ($rank==6) {
    $ret = $ls->rank6[$lang];
	} else if ($rank==7) {
    $ret = $ls->rank7[$lang];
	} else {
		$ret = $ls->rank1[$lang];
	}
	if ($rank>=5) {
		if ($type==1) {
			$ret = "<b>$ret</b>";
		} else {
			$ret = "<b class=badge>$ret</b>";
		}
	}
	return $ret;
}

function ggRegister1($mem_id) {
  global $db;
    $now = new DateTime("NOW");

  $setup = load_setup();
  $bonus = array(40,20,20);
  $bonus_lvl = 3;

  $mem = load_user($mem_id);
  $username = $mem->username;
  $i = 0;
  $op_level = 1;
  While ($mem->referral > 0 and $i<$bonus_lvl) {
    $amt = $bonus[$i];
    $ref = load_user($mem->referral);

   $rs = $db->query("INSERT INTO  tblmavro (id,mem_id,username,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,op_level,incentive)
      VALUES (NULL, '$mem->referral', '$username', 'N',  'N','".$now->format('Y-m-d H:i:s')."',0,  '1', 4,0,$amt,  $amt,  '$username',  0,0,0)");

    $i += 1;
    $mem = mysqli_fetch_object($db->query("select * from tblmember where id = $mem->referral"));
  }
}

function ggRefreshPH($uid) {
  global $db;
	$rm = $db->query("select * from tblmavro where mem_id=$uid and wallet=1 and plan=1") or die ($db->error);
	while ($row = mysqli_fetch_object($rm)) {
        if ($row->date_close == '0000-00-00 00:00:00') {
            $date = new DateTime("NOW");
            $now = ggDateToString($date);
        } else {
            $now = $row->date_close;
        }
        $days = ggInterestDays($row->date_created,$now);
    	if ($days > 30) $days = 30;
        $row->future_amount = $row->real_amount * (1 + 0.01 * $days + $row->incentive/100) + $row->bonus;
        $db->query("update tblmavro set future_amount=$row->future_amount where id=$row->id") or die($db->error);
    }
}

function ggNextPH($op) {
  $ret = "";
  $now = new datetime("now");
  $hour = $now->format("H");
  $min = $now->format("i");
  $p0 = 24; // 24 hours avail
  $p1 = 12;
  $p2 = 16;
  $p3 = 20;
  $p4 = 23; // Period
  $d1 = 60; // Duration 60 = entire hour
  if ($op == "countdown") {
    $ret = $now->format("Y/m/d")." ".($hour+1).":00:00";
  } else if ($op == "period") {
    if ($hour<$p1) {
       $ret = "中午12点";
    } else if ($hour<$p2) {
       $ret = "下午4点";
    } else if ($hour<$p3) {
       $ret = "下午8点";
    } else if ($hour<$p4) {
       $ret = "晚上11点";
    } else {
       $ret = "中午12点";
    }
  } else if ($op == "timer") {
    if (($p0 == 24 || $hour==$p1 || $hour==$p2 || $hour==$p3 || $hour==$p4) && ($min<$d1 || $d1==60)) {
      $ret = "";
    } else if ($hour==$p1-1 || $hour==$p2-1 || $hour==$p3-1|| $hour==$p4-1) {
      $ret = "<b class=red> ". ggNextPH("period")."</b> 抢单倒数 <b class=red><span id='clock'></span></b>";
    } else {
      $ret = "<b class='red'>申請提供幫助已達上限</b>";
    }
  }
  return $ret;
}

function ggTimeRemain($now,$now1) {
  global $lang;

  $fs= new stdClass();
  $fs->hour = array("Hour","小时","小時");
  $fs->min = array("Min","分钟","小時");
  $fs->expired = array("Expired","超时了","超時了");
  $ret = "";
  $now2 = new datetime("$now1");
  if ($now2 >= $now) {
    $interval = $now2->diff($now);
    //$interval = date_diff($now,$now2);
    $days = $interval->format("%d");
    $hours = $interval->format("%h");
    $mins = $interval->format("%i");
    $ret = ($days*24 + $hours) .' '.$fs->hour[$lang].' '. $mins .' '.$fs->min[$lang];
  } else {
    $ret = "<b class=red>".$fs->expired[$lang]."</b>";
  }
  return $ret;
}

function ggMavro($c) {
	global $user;
	ggRefreshPH($user->id);
	$deposit = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='B' and date_release <= now()");

	$ret = $deposit->amt;
	if ($c==1) {
		$ret = intval($ret/100) * 100;
	}
	return $ret;
}

function ggRefer($c) {
	global $user;
	$deposit = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='R' and date_release <= now()");

	$ret = $deposit->amt;
	if ($c==1) {
		$ret = intval($ret/100) * 100;
	}
	return $ret;
}

function ggManager($c) {
	global $user;
	$deposit = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='M' and date_release <= now()");

	$ret = $deposit->amt;
	if ($c==1) {
		$ret = intval($ret/100) * 100;
	}
	return $ret;
}

function ggPinCount($pin_type ="") {
  global $user;
  $ret = ggFetchValue("select count(id) as ctr from tblpin".$pin_type." where managerid=$user->id and status='N'");
  return $ret;
}

?>