<?php
header('Content-Type: text/html; charset=utf-8');
$db = new PDO("sqlite:Soho_UserV1.sqlite3");
//=============Configure Settings================
$username = "40243102";
$password = "40243101";
$exam_opt = 0;         	// 0 = 2600 words.
				// 1 = 5200 words.
//DEBUG Mode. 0 = Off, 1 = On.
$debug = 0;	
//=================Take Login Cookies======================
$login_url = "http://140.130.28.17/index.asp";
$postLoginData = array(
		"cust_id" => $username,
		"cust_pass" => $password,
		"url" => '/index.asp',
		"Action" => 'MLogin',
		"profile" => ''
		);
//Get first cookie
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $login_url);
curl_setopt($ch, CURLOPT_USERAGENT,
    "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_exec($ch);
curl_close($ch);
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $login_url.'?m=false');
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postLoginData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$result = curl_exec($ch);
curl_close($ch);
$login_status = strpos($result, '密碼錯誤');
if ($login_status !== false) {
	echo "login failed!<br>";
} else {
	echo "login success!<br>";
}
//get course list;
$exam_url = "http://140.130.28.17/online_test/word_examine/index.asp";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $exam_url);
curl_setopt($ch, CURLOPT_USERAGENT,
    "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$course_list =  mb_convert_encoding(curl_exec($ch), "utf-8", "big5");
curl_close($ch);
$course_list = explode("menu(this.value);\">", $course_list);
$course_list = explode("</select>", (isset($course_list[1])) ? $course_list[1] : null);
echo "<Select>";
echo $course_list[0];
echo "</select>";
/*
$pure_course_list = Array();
for ($i=0; $i<count($course_list); $i++){
	if(strpos($course_list[$i], '</option>') !== false){
		array_push($pure_course_list, $course_list[$i]);
	}
}
$course_list = array();
for ($i=0; $i<count($pure_course_list); $i++){
	$course_list = explode("</option>", $pure_course_list[$i]);
}
print_r($course_list);
*/	
/*
//==========5200 Extra auth page==============
if ($exam_opt){
	$exam_url = "http://140.130.28.17/online_test/word_examine/index.asp?tid=1099";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $exam_url);
	curl_setopt($ch, CURLOPT_USERAGENT,
	    "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_exec($ch);
	curl_close($ch);
}
//=======5200 words exam======
if ($exam_opt)
	$exam_url = "http://140.130.28.17/online_test/word_examine/custom_home.asp";
else	//=======2600 words exam=======
	$exam_url = "http://140.130.28.17/online_test/word_examine/elementary_home.asp?wg=1";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $exam_url);
curl_setopt($ch, CURLOPT_USERAGENT,
    "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$rank = mb_convert_encoding(curl_exec($ch), "utf-8", "big5");
curl_close($ch);
//==============================
$rank = explode('目前所在級別 ：',$rank);
$rank = explode('</div>', isset($rank[1]) ? $rank[1] : null);
$rank = explode('-', isset($rank[0]) ? $rank[0] : null);
$level = $rank[0];
$course = $rank[1];
echo "level : $level <br> course : $course";
/*
//========START WORD SOLVER=========
if($debug){
	$max_level = 1;
	$max_course = 1;
	$level = 0;
	$course = 0;
} else {
	$max_level = ($exam_opt)?53:26;
	$max_course = 11;
}
for($level; $level < $max_level; $level++){
	for($course; $course < $max_course; $course++){
		for($kind = 1; $kind<3; $kind++){
			for($wid=0; $wid<11; $wid++){
				if ($exam_opt == 0){
					$promotion_url = "http://140.130.28.17/online_test/word_examine/ajaxGetpromoteword.asp";
				} else {
					$promotion_url = "http://140.130.28.17/online_test/word_examine/ajaxGet_custom_promoteword.asp";
				}
				if($wid == 0 AND $kind == 1){
					$postdata ="wid=".$wid."&kind=".$kind."&action=next&tag=start&u_ans=1";
				} else {
					$postdata ="wid=".$wid."&kind=".$kind."&action=next&tag=&u_ans=".$answer;
				}
				$headers = array(
					'Content-Type: application/x-www-form-urlencoded',
					'X-Requested-With: XMLHttpRequest',
				);
				
				$ch=curl_init();
				curl_setopt($ch, CURLOPT_URL, $promotion_url);
				curl_setopt($ch, CURLOPT_USERAGENT,
				    "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
				curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, false);
				$html = curl_exec ($ch);
				curl_close($ch);
				if($kind == 2){
					// get the sentence
					$sentence = explode('<span class="style8">', $html);
					$sentence = explode('</span>', isset($sentence[1]) ? $sentence[1] : null);
					$sentence = $sentence[0];
					if($debug == 1){
						print_r ($sentence);
						echo "<br>";
					}
					// get sentence done then fetch answer
					if($debug ==1){
						echo "SELECT esentence FROM tblword WHERE csentence = '".$sentence."'<br>";
					}
					$query = $db->prepare("SELECT esentence FROM tblword WHERE csentence = ?");
					$query->execute(Array($sentence));
					$result = $query->fetch();
					$answer = $result['esentence'];
					if($debug ==1){
						print_r ($answer);
						echo "<br>";
					}
					$answer = explode('[', $answer);
					$answer = explode(']', isset($answer[1]) ? $answer[1] : null);
					$answer = $answer[0];
					if($debug ==1){
						print_r ($answer);
						echo "<br>";
					}
					$answer = urlencode($answer);
				} else {
					// get the word
					$word = explode('<font style="font-size:20pt" face="Times New Roman">', $html);
					$word = explode('</font>', isset($word[1]) ? $word[1] : null);
					$word = $word[0];
					$option = explode('onclick="document.getElementById(\'u_ans\').value=this.value', $html);
					$option = explode('<input name="radiobutton" type="radio"  value="', $option[0]);
					$option = explode('"', isset($option[1]) ? $option[1] : null);
					$option = $option[0];
					if($debug ==1){
						print_r ($word);
						echo "<br>";
					}
					$query = $db->prepare("SELECT cword_A FROM tblword WHERE eword = ? AND (cword_A = ? OR cword_B = ? OR cword_C = ? OR cword_D = ?)");
					$query->execute(Array($word, $option, $option, $option, $option));
					$result = $query->fetch();
					//print_r ($result);
					$answer = $result['cword_A'];
					if($debug ==1){
						print_r ($answer);
						echo "<br>";
					}
					$answer = rawurlencode($answer);
					if ($debug ==1){
						print_r ($answer);
						echo "<br>";
					}
				}
				if($wid == 10 && $kind == 2)
					echo $html;
			}
		}
	}
	echo "course:$course<br>";
	$course = 1;
}
echo "level:$level<br>";
*/
?>
