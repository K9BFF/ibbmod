<?php
if (phpversion()<"4.1.0") {
  $_GET = $HTTP_GET_VARS;
  $_POST = $HTTP_POST_VARS;
  $_SERVER = $HTTP_SERVER_VARS;
  $_COOKIE = $HTTP_COOKIE_VARS;
}
/***********************************
  * PHP-I-BOARD
  *               by ToR http://php.s3.to/
  *
  * original by http://www.cj-c.com/
  ***********************************/
// 2003/02/14 v1.0
// 2003/02/22 v1.1 �w���v�A���s����
// 2003/02/28 v1.2 �g�ёΉ�
// 2003/03/04 v1.2b �Ǘ����[�h�C��
// 2003/03/08 v1.2d DoCoMo�p�X�L���A���X���ǉ�
// 2003/03/11 v1.2e url��urlencode,skin_other�X�V�i�Ǘ��p�X
// 2003/03/14 v1.3 �Ǘ��҃A�C�R���̃o�O�C���A�N�b�L�[�A�C�R��
// 2003/03/17 v1.3b �Ǘ��҃A�C�R���N�b�L�[
// 2003/03/20 v1.3c �F�w�薳����
// 2003/03/30 v1.4 �֎~�z�X�g�A�֎~���[�h�A���ꕶ���ǉ�
// 2003/04/03 v1.45 �摜�J�E���^�o�O�C��
// 2003/04/06 v1.5 �w�b�h���C�����A���X���e�L���z�X�g
// 2003/04/08 v1.56 ���X���e�A�C�R��{$oyaicon}�BURL�N�b�L�[{$curl}
// 2003/07/26 v1.6 �ߋ����O�I�t���Ńt�@�C���������o�O�B570:if (PAST && is_array($kako))
// 2004/01/08 v1.65 EzWEB�X�L������~�X
// 2009/06/22 v1.7 XSS�A�ިڸ�����ް�ِƎ㐫���C��
// 2010/03/25 v1.8 ���[���ʒm�@�\�ǉ�
/*
  ���g�p���@�@
�@�@�Eibbs.dat,icount.dat,ilog.log�̑�����666��646�ɂ���B
  �@�E�ߋ����O�g�p�̏ꍇ�͐����ިڸ�؁i./�Ȃ�public_html��)�̑���777��757�ɂ���
*/
require_once("htmltemplate.inc"); 

// �X�N���v�g��
define(PHP_SELF, "ibbs.php");

// ���O�t�@�C����(������606,646,666���ɂ���)
define(LOGFILE, "ibbs.dat");

// �Ǘ��p�X
define(ADMINPASS, "sage17");

// ���e�ʒm���[���𑗂�yes=1 no=0
define(NOTICE, 0);
// �ʒm���[�����M��
$admin_mail = "all@s.to";

// ���X��������L�����グ��Hyes=1 no=0
define(AGE, 1);

// URL�����������N����H
define(AUTOLINK, 1);
// ���e��̔�ѐ�
$jump = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

// ���e�����������B�ォ�疼�O�A�^�C�g���A�R�����g�B���p��
define(MAXNAME, 32);
define(MAXSUBJ, 32);
define(MAXCOM, 1000);
// �ŏ�������
define(MINCOM, 4);
// ���s������
define(MAXBR, 20);

// �e�L���ő働�O�ێ�����
define(MAXLOG, 40);

// �w�b�h���C���\������(���̐��ȉ��Łj
define(MAXHEADLINE, 30);

// �F�w�肪�Ȃ����̐F
define(NOCOL, "#666666");

// �A�C�R���̐ݒ�
// �A�C�R���p�f�B���N�g��
define(I_DIR, "./Icon/");
// HTML�\���p�A�C�R���ꗗ '�t�@�C����'=>'�A�C�R����'���y�A��
$html_icon = array('randam'=>'Random','cat1.gif'=>'Cat','dog1.gif'=>'Dog',
                   'rob1.gif'=>'Robot','pen1.gif'=>'Penguin','td1.gif'=>'Bear',
                   'rabi1.gif'=>'Rabbit','ball1.gif'=>'Bouncing Ball','tel1.gif'=>'Ghost Thing','master'=>'Ram');
// �����_���̉摜���
$rand_icon = array('cat1.gif','dog1.gif','rob1.gif','pen1.gif','td1.gif','rabi1.gif','ball1.gif','tel1.gif');

// �Ǘ��җp�A�C�R��
$mas_i= array('master.gif','master2.gif','master3.gif');
// �Ǘ��҃A�C�R���p�X���[�h �폜�L�[�ɓ���� �g�������邱�Ƃɂ���ĕ����̊Ǘ��҃A�C�R�����g�p�\
$mas_p= array('7777','8888','9999');
$Ico_h= 5; // �A�C�R���ꗗ�ŉ��s�����鐔

// �����F
$font = array('#585858','#C043E0','#3947C6','#F25353','#EF8816','#67AC22','#34A086','#7191FF','#FF819B');
// �g���F
$hr   = array('#FAAFAB','#FBB85E','#C785E0','#9FC1FB','#EDE94E','#70D179','#969696','#C8CCFF','#E0D0B0');

// �{���֎~�z�X�g
$no_host[] = 'kantei.go.jp';
$no_host[] = 'anonymizer.com';

// �g�p�֎~���[�h
$no_word[] = '����';
$no_word[] = '<img';
$no_word[] = '<script';
$no_word[] = 'http:';

// �ߋ����O�@�\���g���HYes=1,No=0�i�g�p����ꍇ�͕ۑ��ިڸ�؂�757,777���ɂ���j
define(PAST, 0);
define(PASTLOG, "ilog.log"); // �ߋ����O�J�E���g�t�@�C��
define(PASTDIR, "./");       // �ߋ����O�����f�B���N�g��(/�ŏI��鎖)
define(PASTSIZE, "100");     // �ߋ����O�L�^�� KB
define(PASTDEF, 20);         // �ߋ����O���[�h�ł̕\������

// �J�E���^���g���H
define(COUNTER, 1);
define(COUNTIMG, "");    //�J�E���^�摜�̃f�B���N�g���i�e�L�X�g�̏ꍇ�͋�B/�ŏI���j
define(COUNTLOG, "icount.dat"); //�J�E���^�t�@�C��(������606,646,666���ɂ���)

// �@�픻��
//$ua = explode("/", getenv('HTTP_USER_AGENT'));
//ibbs.php?ua=DoCoMo�Ƃ�
if ($_GET['ua']) $ua[0] = $_GET['ua'];
if(preg_match("/^KDDI/",$ua[0])){
  //WAP2.0�̏ꍇ
  define(MAINFILE, "i_skin_main.html");
  define(OTHERFILE, "i_skin_other.html");
  define(PAGEDEF, 5);
  define(RESDEF, 3);
  define(RESEVERY, 5);
  define(MOBILE, 1);
}
switch( $ua[0] ){
case "PDXGW" :
  //H"
case "UP.Browser" :
  //HDML�̏ꍇ
case "J-PHONE" :
  //J-PHONE�̏ꍇ
case "DoCoMo" :
  // �f�U�C���t�@�C���g��
  define(MAINFILE, "i_skin_main.html");
  define(OTHERFILE, "i_skin_other.html");
  define(PAGEDEF, 5);//�e�L���\����
  define(RESDEF, 3);//���X�\����
  define(RESEVERY, 5);//���X�H������
  define(MOBILE, 1);//�g�у��[�h�͓��t�\���ȗ�
  break;
case 'line'://��s���X
  // �f�U�C���t�@�C��PC
  define(MAINFILE, "skin_main_line.html");
  define(OTHERFILE, "skin_other.html");
  // 1�y�[�W�ɕ\������e�L����
  define(PAGEDEF, 5);
  // 1�e�L���ɕ\�����郌�X��
  define(RESDEF, 5);
  // �擪�H���A�ŐV�H���\��
  define(RESEVERY, 10);
  break;
default :
  // �f�U�C���t�@�C��PC
  define(MAINFILE, "skin_main.html");
  define(OTHERFILE, "skin_other.html");
  // 1�y�[�W�ɕ\������e�L����
  define(PAGEDEF, 5);
  // 1�e�L���ɕ\�����郌�X��
  define(RESDEF, 5);
  // �擪�H���A�ŐV�H���\��
  define(RESEVERY, 10);
  // �g�ю��͓��t���ȗ�
  define(MOBILE, 0);
  break;
}
//---�ݒ肱���܂�

// �֎~�z�X�g
if (is_array($no_host)) {
  $host = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
  foreach ($no_host as $user) {
    if(eregi($user, $host)){
      header("Status: 204\n\n");//�󔒃y�[�W
      exit;
    }
  }
}
/*-- �J�E���^ --*/
if (COUNTER) {
  // �������Z�b�g�B�����[�h�h�~�p
  setcookie("ibbs[count]", 1, time()+14*86400);
  // �������Ȃ���Ώ��K��B�ŃJ�E���g�A�b�v
  if (!isset($_COOKIE['ibbs']['count'])) {
    $fp = fopen(COUNTLOG, "r+");
    $c = fgets($fp, 10);
    $c++;
    rewind($fp);
    set_file_buffer($fp, 0);
    flock($fp, LOCK_EX);
    fputs($fp, $c);
    fclose($fp);
  }
  $cc = file(COUNTLOG);
  $c = $cc[0];
  // �摜���g���ꍇ
  if (COUNTIMG) {
    // alt�𓾂�
    $size = @getimagesize(COUNTIMG."0.gif");
    // ���������[�v
    for ($i = 0; $i < strlen($c); $i++) {
      $n = substr($c, $i, 1);
      $count.="<img src=\"".COUNTIMG.$n.".gif\" alt=".$n." ".$size[3].">";
    }
    $c = $count;
  }
}
/*-- �FHTML�쐬 --*/
function radio_list($name, $select="") {
  global $font,$hr;
  // �����������ꍇ��0�ԖڂɃZ�b�g
  if (!isset($_COOKIE['ibbs'][$name])) $select = ${$name}[0];
  foreach ($$name as $l=>$col) {
    if ($_COOKIE['ibbs'][$name] == $col || $select == $col) $arg[$l]['chk'] = " checked";
    $arg[$l]['color'] = $col;
  }
  return $arg;
}
/*-- �A�C�R��HTML�쐬 --*/
function option_list($select="") {
  global $html_icon,$mas_i;
  $l = 0;
  if (in_array($_COOKIE['ibbs']['ico'], $mas_i)) $select = "master";
  foreach ($html_icon as $file=>$name) {
    if ($_COOKIE['ibbs']['ico'] == $file || $select == $file) $arg[$l]['sel'] = " selected";
    $arg[$l]['file'] = $file;
    $arg[$l]['name'] = $name;
    $l++;
  }
  return $arg;
}
/*-- �S�L���\�� --*/
function all_view($page,$mode="") {
  global $html_icon,$font,$hr,$c;

  if ($mode == "admin") {
    $pass = ($_GET['pass']) ? $_GET['pass'] : $_POST['pass'];
    if ($pass != ADMINPASS) error("Password is Incorrect!");
  }
  // ���O��z��Ɋi�[
  $lines = file(LOGFILE);
  // �ŏ��̓y�[�W0
  if (!$page) $page = 0;
  $p = 1;
  $o = 0;
  // �ŏI�X�V��
  list(,,,,$up) = explode("<>", $lines[0]);
  $arg['update'] = gmdate("Y/m/d(D) H:i:s",time()+9*60*60);
  // �w�b�h���C��
  for ($h = 1; $h < count($lines); $h++) {
    list($num,,,,$subj,,,,,$type,)  = explode("<>", $lines[$h]);
    // ���X�̏ꍇ
    if ($type) {
      if (!is_array($res[$type])) $res[$type] = array();
      array_unshift($res[$type], $lines[$h]);
    }
    // �e�L���̏ꍇ�B�e�z��쐬
    else {
      $oya[] = $lines[$h];
      $res_num = count($res[$num]);
      $o_num++;
      $ptop = PAGEDEF * $p;

      if ($ptop < $o_num) {
        $url = "?page=$ptop";
        $p++;
      }
      if ($mode != "admin") {
        $arg['headline'][] = array('url'=>"{$_SERVER['PHP_SELF']}$url#$num", 'subj'=>$subj, 'cnt'=>$res_num);
      }
    }
  }
  if (count($arg['headline']) > MAXHEADLINE) {
    array_splice($arg['headline'], 0, $page);
    array_splice($arg['headline'], MAXHEADLINE);
  }
  // �e�L���W�J
  for ($i = $page; $i < $page+PAGEDEF; $i++) {
    if (!trim($oya[$i])) continue;
    list($num,$date,$name,$email,$subj,$com,$url,$col,$icon,$type,,$host) = explode("<>", $oya[$i]);
    list($color,$b_color) = explode(";", $col);
    if ($color == "") $color = NOCOL;
    if ($b_color == "") $b_color = NOCOL;
    if ($url) $url = "http://".$url;
    if ($icon) $icon = I_DIR.$icon;
    if ($mode!="admin" && AUTOLINK) $com = autolink($com);
    if (MOBILE) $date = substr($date, 5, 5) . substr($date, 15, 6);
    // �Ǘ����[�h���{���ȗ�
    if ($mode == "admin") {
      $com = str_replace("<br>", " ", $com);
      $com = substr($com, 0, 60) . "..";
    }
    $cnt = $i+1;
    $res_cnt = count($res[$num]);
    // �e�L���i�[
    $arg['oya'][$o] = compact('cnt','res_cnt','num','date','name','email','subj','com','b_color','color','icon','url','host','page');
    // ���X���I�[�o�[�H
    $rst = $res_cnt-RESDEF;
    if ($rst <= 0) {
      $rst = 0;
      $arg['oya'][$o]['over'] = false;
    }
    else {
      $arg['oya'][$o]['over'] = true;
    }
    // �Ǘ����[�h���͑S���X�\��
    if ($mode == "admin") {
      $rst = 0;
      $arg['pass'] = $pass;
      $arg['size'] = filesize(LOGFILE);
    }
    // ���X�W�J
    for ($j=$rst; $j<count($res[$num]); $j++) {
      list($rnum,$rdate,$rname,$remail,$rsubj,$rcom,$rurl,$rcol,$ricon,,,$host) = explode("<>", $res[$num][$j]);
      list($rcolor,$rb_color) = explode(";", $rcol);
      if ($rcolor == "") $rcolor = NOCOL;
      if ($rb_color == "") $rb_color = NOCOL;
      if ($rurl) $rurl = "http://".$rurl;
      if ($ricon) $ricon = I_DIR.$ricon;
      if ($mode!="admin" && AUTOLINK) $rcom = autolink($rcom);
      if ($mode == "admin") {
        $rcom = str_replace("<br>", " ", $rcom);
        $rcom = substr($rcom, 0, 60) . "..";
      }
      // ���X�L���i�[
      $rres[$o][] = array('cnt'=>$j+1,'num'=>$rnum,'date'=>$rdate,'name'=>$rname,'email'=>$remail,'subj'=>$rsubj,
                          'com'=>$rcom,'b_color'=>$rb_color,'color'=>$rcolor,'icon'=>$ricon,'url'=>$rurl,'host'=>$host
                          );
    }
    // �e�L���i�[
    $arg['oya'][$o]['res'] = $rres[$o];
    $o++;
  }

  if ($mode == "admin") $qry = "&mode=admin&pass=".$arg['pass'];
  // �y�[�W�O/��
  $prev = $page - PAGEDEF;
  $next = $i;
  if ($prev >= 0)          $arg['prev'] = "{$_SERVER['PHP_SELF']}?page=$prev$qry";
  if ($next < count($oya)) $arg['next'] = "{$_SERVER['PHP_SELF']}?page=$next$qry";
  // �y�[�W���ڈړ�
  $tpage = (int)count($oya) / PAGEDEF;
  for ($a = 0; $a < $tpage; $a++) {
    if ($a == $page/PAGEDEF) $arg['paging'].= "[<b>$a</b>] ";
    else $arg['paging'].= "[<a href=\"{$_SERVER['PHP_SELF']}?page=$pp$qry\"><b>$a</b></a>] ";
    $pp += PAGEDEF;
  }

  $arg['count'] = $c;
  $arg['page_def'] = PAGEDEF;
  $arg['res_def'] = RESEVERY;
  $arg['total'] = count($lines) - 1;
  $arg['oyakiji'] = count($oya);
  $arg['reskiji'] = $arg['total'] - $arg['oyakiji'];
  $arg['maxcom'] = MAXCOM;
  if (PAST) $arg['kako'] = true;

  // �N�b�L�[
  $arg['cname'] = $_COOKIE['ibbs']['name'];
  $arg['cemail'] = $_COOKIE['ibbs']['email'];
  $arg['cpass'] = $_COOKIE['ibbs']['pass'];
  $arg['curl'] = $_COOKIE['ibbs']['url'];

  if ($mode == "admin") {
    $arg['admin'] = true;
    $arg['title'] = "Manage";
    $arg['self'] = PHP_SELF;
    HtmlTemplate::t_include(OTHERFILE,$arg);
  }
  else {
    $arg['font'] = radio_list("font");
    $arg['hr']   = radio_list("hr");
    $arg['icon'] = option_list();
    $arg['self'] = PHP_SELF;
    HtmlTemplate::t_include(MAINFILE,$arg);
  }
}

/*-- �ʕ\�� --*/
function res_view($num) {
  global $html_icon;

  $res = array();

  $fd = fopen (LOGFILE, "r");
  fgets($fd, 4096);
  while (!feof ($fd)) {
    $buf = fgets($fd, 4096);
    $line = explode("<>", $buf);
    // �e�L��
    if ($line[9]=="0") {
      // �Y���L���Ȃ�I��
      if ($num == $line[0]) break;
      // �Ⴄ�Ȃ�ꂩ��
      $res = array();
    }
    else{
      array_unshift($res, $buf);// ���X�𒙂߂�
    }
  }
  fclose ($fd);

  // old-�ŏ�����H���Anew-�ŐV�H���Aall-�S���X�\���A�ʏ�-�ŐVX��
  switch ($_GET['res']) {
    case 'old': $st = 0; $to = RESEVERY; break;
    case 'new': $st = count($res)-RESEVERY; $to = count($res); break;
    case 'all': $st = 0; $to = count($res); break;
    default:    $st = count($res)-RESDEF; $to = count($res); break;
  }
  if ($st < 0) $st = 0;

  // ���X�W�J
  for ($i = $st; $i < $to; $i++) {
    if ($res[$i] == "") continue;
    list($rnum,$rdate,$rname,$remail,$rsubj,$rcom,$rurl,$rcol,$ricon,,,$rhost) = explode("<>", $res[$i]);
    list($rcolor,$rb_color) = explode(";", $rcol);
    if ($rcolor == "") $rcolor = NOCOL;
    if ($rb_color == "") $rb_color = NOCOL;
    if ($rurl) $rurl = "http://".$rurl;
    // ���p
    if (isset($_GET['q']) && $_GET['q'] == $rnum) {
      $q_com = "&gt;$rcom";
      $rrcom = str_replace("<br>","\r&gt;",$q_com);
    }
    else {
      if (AUTOLINK) $rcom = autolink($rcom);
    }
    // ���X�L���i�[
    $rres[] = array('cnt'=>$i+1,'num'=>$rnum,'date'=>$rdate,'name'=>$rname,'email'=>$remail,'subj'=>$rsubj,
                    'com'=>$rcom,'b_color'=>$rb_color,'color'=>$rcolor,'icon'=>I_DIR.$ricon,'url'=>$rurl,'host'=>$rhost
                    );
  }
  // �e�L��
  list($num,$date,$name,$email,$subj,$com,$url,$col,$icon,$type,,$host) = explode("<>", $buf);
  list($color,$b_color) = explode(";", $col);
  if ($color == "") $color = NOCOL;
  if ($b_color == "") $b_color = NOCOL;
  if ($url) $url = "http://".$url;
  // ���p
  if (isset($_GET['q']) && $_GET['q'] == $num) {
    $q_com = "&gt;$com";
    $rrcom = str_replace("<br>","\r&gt;",$q_com);
  }
  else {
    if (AUTOLINK) $com = autolink($com);
  }
  // �e�L���i�[
  $arg = array('res'=>$rres,'num'=>$num,'date'=>$date,'name'=>$name,'email'=>$email,
                'subj'=>$subj,'com'=>$com,'b_color'=>$b_color,'color'=>$color,'oyaicon'=>I_DIR.$icon,'url'=>$url,
                'page'=>$_GET['page'],'rsubj'=>"Re: $subj", 'rcom'=>$rrcom,'host'=>$host
                );
  $arg['res_def'] = RESEVERY;
  $arg['res_mode'] = true;
  $arg['font'] = radio_list("font");
  $arg['hr']   = radio_list("hr");
  $arg['icon'] = option_list();
  $arg['title'] = "Post No. $num Reply [Normal/Quote Display]";
  $arg['maxcom'] = MAXCOM;
  $arg['self'] = PHP_SELF;
  // �N�b�L�[
  $arg['cname'] = $_COOKIE['ibbs']['name'];
  $arg['cemail'] = $_COOKIE['ibbs']['email'];
  $arg['cpass'] = $_COOKIE['ibbs']['pass'];
  $arg['curl'] = $_COOKIE['ibbs']['url'];

  HtmlTemplate::t_include(OTHERFILE,$arg);
}
/*-- �����ݑO���� --*/
function check() {
  global $rand_icon,$mas_i,$mas_p,$no_word;
  //No<>Y/m/d(D) h:i:s<>name<>email<>subj<>com<>url<>#ffffff;#back<>icon.gif<>oyaNo<>crypt<>ip<><>

  if (trim($_POST['name'])=="")   error("No Name Entered.");
  if (ereg("^( |�@|\t|\r|\n)*$",$_POST['comment'])) error("No Comment Entered.");
  if (strlen($_POST['pass']) > 8) error("Deletion key must be at least 8 characters long.");
  if (strlen($_POST['name']) > MAXNAME) error("Name is too long.");
  if (strlen($_POST['subject']) > MAXSUBJ)  error("Title is too long.");
  if (strlen($_POST['comment']) > MAXCOM)  error("Body text is too long.");
  if (strlen($_POST['comment']) < MINCOM)  error("Body Text is too short.");
  if ($_POST['email'] && !ereg("(.*)@(.*)\.(.*)", $_POST['email']))
    error("Email Invalid.");

  // �֎~���[�h
  if (is_array($no_word)) {
    foreach ($no_word as $fuck) {
      if (ereg($fuck, $_POST['comment'])) error("Invalid Characters in Body Text");
      if (ereg($fuck, $_POST['subject'])) error("Invalid Characters in Subject");
      if (ereg($fuck, $_POST['name'])) error("Invalid Characters in Name");
    }
  }
  if (preg_match("/(<a\b[^>]*?>|\[url(?:\s?=|\]))|href=/i", $_POST['comment'])) error("Error!");
  // ����
  if ($_POST['sex']) $_POST['subject'] = $_POST['sex']."/".$_POST['subject'];

  // �����_���A�C�R��
  if ($_POST['ico']=="randam") {
    mt_srand((double)microtime()*1000000);
    $randval = mt_rand(0, (count($rand_icon)-1));
    $ico = $rand_icon[$randval];
  }
  // �Ǘ��҃A�C�R��
  elseif ($_POST['ico']=="master") {
    $find = false;
    foreach ($mas_p as $l=>$mpass) {
      if ($_POST['delkey'] == $mpass) {
        $ico = $mas_i[$l];
        $find = true;
      }
    }
    if (!$find) error("Admin Icon cannot be used.");
  }
  else{
    $ico = $_POST['ico'];
  }
  // �S$_POST�ɓK�p
  $post = array_map("htmlspecialchars",$_POST);
  if (get_magic_quotes_gpc())
    $post = array_map("stripslashes", $post);
  // ����
  if (trim($post['subject'])=="") $post['subject'] = "(Untitled)";
  // ���s����
  $comment = str_replace("\r\n", "\r", $post['comment']);
  $comment = str_replace("\r", "\n", $comment);//���s��������
  $comment = preg_replace("/\n{2,}/", "\n\n", $comment);//2�s�ȏ�̉��s��2�s��
  if (substr_count($comment, "\n") > MAXBR) error("Line break is too long!");
  $comment = eregi_replace("&amp;([0-9a-z#]+);", "&\\1;", $comment);
  $post['comment'] = str_replace("\n", "<br>", $comment);//\n��br��

  // ���ԁAIP�A�폜�L�[�A�F
  $post['now'] = gmdate("Y/m/d(D) H:i:s",time()+9*60*60);
  $post['url'] = eregi_replace("^http://", "", $post['url']);
  $post['url'] = str_replace(" ", "", $post['url']);
  $post['ico'] = $ico;
  $post['ip'] = gethostbyaddr(getenv("REMOTE_ADDR"));

  return $post;
}
/*-- ���O�����ݏ��� --*/
function log_write($post) {
  global $admin_mail;
  // �VNO.
  $fp = fopen(LOGFILE, "r");
  $fline = fgets($fp, 2048);
  fclose($fp);
  // �d���J�L�q�`�F�b�N
  list($num,$rname,$rcom,$rip,)  = explode("<>", $fline);
  if ($rname == $post['name'] && $rcom == $post['comment']) error("You just said this!");
  // �VNo.
  $newnum = $num+1;
  $font = $post['font'].";".$post['hr'];
  $post['pass'] = crypt($post['delkey'], my_crypt($post['delkey']));
  // �擪�p�f�[�^�A�L���f�[�^����
  $newfline = "$newnum<>{$post['name']}<>{$post['comment']}<>{$post['ip']}<>".time()."\n";
  $newline = "$newnum<>{$post['now']}<>{$post['name']}<>{$post['email']}<>{$post['subject']}<>{$post['comment']}<>{$post['url']}<>$font<>{$post['ico']}<>{$post['type']}<>{$post['pass']}<>{$post['ip']}<><>\n";
  // �N�b�L�[�Z�b�g�A2�T�ԗL��
  setcookie("ibbs[name]", $post['name'], time()+14*86400);
  setcookie("ibbs[email]", $post['email'], time()+14*86400);
  setcookie("ibbs[ico]", $post['ico'], time()+14*86400);
  setcookie("ibbs[font]", $post['font'], time()+14*86400);
  setcookie("ibbs[hr]", $post['hr'], time()+14*86400);
  setcookie("ibbs[pass]", $post['delkey'], time()+14*86400);
  setcookie("ibbs[url]", $post['url'], time()+14*86400);

  if (NOTICE) {
    $mail_body = <<<EOL
There was a post
Name     : {$post['name']}
Title : {$post['subject']}
�t�q�k�@ : {$post['url']}
Reply to Post No.  : {$newnum}
Text : 
{$post['comment']}
--------------------------------
{$post['now']}
{$post['ip']}
EOL;

    $mail_body  = str_replace("<br>",   "\n", $mail_body);
    $mail_sub = "Reply Notifications to ".$_SERVER['REQUEST_URI'];
    if (ereg("^[0-9A-Za-z._-]+@[0-9A-Za-z.-]+$", $post['email'])) {
    $from = " <".$post['email'].">";
    } else {
      $from = " <nomail@xxxx.xxx>";
    }
    $head = "From: ".$from;
    //���M
    mb_language('english');
    mb_internal_encoding('SJIS');
    @mb_send_mail($admin_mail, $mail_sub, $mail_body, $head);
  }
	
  $lines = file(LOGFILE);
  array_shift($lines);//��s�ڗ���

  // �e�L���̏ꍇ�B�擪�ɒǉ�
  if ($post['type'] == 0) {
    array_unshift($lines, $newline);
    // �ߋ����O
    $kako = array();
    $over = false;
    for ($i = 0; $i < count($lines); $i++) {
      list($num,,,,,,,,,$type,)  = explode("<>", $lines[$i]);
      if ($over) {
        if (PAST) array_push($kako, $lines[$i]);
        $lines[$i] = "";
      }
      if ($type == 0) $oya++;
      if ($oya >= MAXLOG) $over = true;
    }
    if (PAST && is_array($kako)) past_write($kako);
  }
  // ���X�̏ꍇ�B�Y���L������
  else{
    $find = false;
    $res = array();
    for ($i = 0; $i < count($lines); $i++) {
      list($num,,,,,,,,,$type,)  = explode("<>", $lines[$i]);
      if ($post['type'] == $type) {
        if (!$find) $st = $i;
        $find = true;
        array_push($res, $lines[$i]);
      }
      elseif ($type == 0 && $post['type'] == $num) {
        if (!isset($st)) $st = $i;
        $find = true;
        array_push($res, $lines[$i]);
        array_unshift($res, $newline);
        break;
      }
    }
    if (!$find) error("Post number not found.");
    // �A�Q�̏ꍇ�A�Y���X���폜���āA�V�X���ƌ���
    if (AGE) {
      array_splice($lines, $st, count($res)-1);
      $newlines = array_merge($res, $lines);
      $lines = $newlines;
    }
    // �T�Q�̏ꍇ�A�V�X���ɒu��
    else{
      array_splice($lines, $st, count($res)-1, $res);
    }
  }
  // �擪�p�f�[�^�ǉ�
  array_unshift($lines, $newfline);
  // ���O�X�V
  update($lines);
}
/*-- �ʋL���폜 --*/
function del() {
  if (trim($_POST['del']) == "") error("No post number entered!!");
  if (trim($_POST['delkey']) == "") error("No password Entered!");

  $lines = file(LOGFILE);
  $find = false;
  for ($i = 1; $i < count($lines); $i++) {
    list($num,,,,$subj,,,,,$type,$cpass,)  = explode("<>", $lines[$i]);
    if ($num == $_POST['del'] || @in_array($num, $_POST['del'])) {
      if (ADMINPASS != $_POST['delkey']) {
        if ($cpass == "") error("There is no Password for this post.");
        if ($cpass != crypt($_POST['delkey'], $cpass)) error("Password is incorrect.");
      }
      $lines[$i] = ($type != "0") ? "" : "$num<><><><><><><><><>$num<><><>\n";
      $find = true;
    }
  }
  if (!$find) error("Post not found.");

  update($lines);
}
/*-- �ʋL���ҏW�\�� --*/
function edit() {
  global $html_icon;

  $del = ($_GET['del']) ? $_GET['del'] : $_POST['del'];
  $delkey = ($_GET['delkey']) ? $_GET['delkey'] : $_POST['delkey'];
  if (trim($_REQUEST['del']) == "") error("Post Number not Entered.");
  if (trim($_REQUEST['delkey']) == "") error("No password entered.");

  $lines = file(LOGFILE);
  $find = false;
  for ($i = 1; $i < count($lines); $i++) {
    list($num,$date,$name,$email,$subj,$com,$url,$col,$icon,$ty,$cpass,) = explode("<>", $lines[$i]);
    if ($num == $del) {
      if (ADMINPASS != $delkey) {
        if ($cpass == "") error("There is no deletion key for this post.");
        if ($cpass != crypt($_POST['delkey'], $cpass)) error("Incorrect Password.");
      }
      $find = true;
      break;
    }
  }
  if (!$find) error("Cannot find post.");

  list($color,$b_color) = explode(";", $col);
  $pass = $delkey;
  $com = str_replace("<br>","\n",$com);
  $arg = compact('num','name','email','subj','com','url','b_color','color','icon','pass');
  $arg['edit_mode'] = true;
  $arg['font'] = radio_list("font", $color);
  $arg['hr']   = radio_list("hr", $b_color);
  $arg['icon'] = option_list($icon);
  $arg['title'] = "Editing Post No. $num";
  $arg['self'] = PHP_SELF;
  HtmlTemplate::t_include(OTHERFILE,$arg);
}
/*-- �ҏW�������� --*/
function rewrite($post, $target) {
  $lines = file(LOGFILE);
  $find = false;

  for ($i = 1; $i < count($lines); $i++) {
    list($num,$now,,,,,,,,$type,$cpass,) = explode("<>", $lines[$i]);
    if ($num == $target && ($cpass == crypt($post['delkey'], $cpass) || $post['delkey'] == ADMINPASS)) {
      $find = true;
      $font = $post['font'].";".$post['hr'];
      $lines[$i] = "$num<>$now<>{$post['name']}<>{$post['email']}<>{$post['subject']}<>{$post['comment']}<>{$post['url']}<>$font<>{$post['ico']}<>$type<>$cpass<>{$post['ip']}<><>\n";
      break;
    }
  }
  if (!$find) error("Failed to edit.");

  update($lines);
}
/*-- ���� --*/
function search() {
  if (trim($_GET['w']) != "") {
    // �X�y�[�X��؂��z���
    $word = htmlspecialchars($_GET['w']);
    $words = preg_split("/(�@| )+/", $word);
    // ���O����
    if ($_GET['logs'] == 0) {
      $lines = file(LOGFILE);
      array_shift($lines);
    }
    elseif (file_exists(PASTDIR.$_GET['logs'].".txt")) {
      $lines = file(PASTDIR.$_GET['logs'].".txt");
    }
    else {
      return false;
    }
    $result = array();
    foreach ($lines as $line) {	//���O�𑖍�
      $find = FALSE;			//�t���O
      foreach ($words as $w) {
        if ($w == "") continue;	//�󕶎��̓p�X
        if (stristr($line, $w)) {	//�}�b�`
          $find = TRUE;
          if ($_GET['kyo']) $line = str_replace($w, "<b style='color:green;background-color:#ffff66'>$w</b>", $line);
        }
        elseif ($_GET['andor'] == "and") {	//AND�̏ꍇ�}�b�`���Ȃ��Ȃ玟�̃��O��
          $find = FALSE;
          break;
        }
      }
      if($find) array_push($result, $line);	//�}�b�`�������O��z���
    }
    $arg['total'] = count($result);
    if (get_magic_quotes_gpc()) $word = stripslashes($word);
    $arg['word'] = $word;

    if (count($result) > 0) {
      $page_def = ($_GET['pp']) ? (int)$_GET['pp'] : PASTDEF;
      $page = ($_GET['page']) ? (int)$_GET['page'] : 0;
      // �L���\��
      for ($i = $page; $i < $page+$page_def; $i++) {
        $oya = $res = "";
        if (!trim($result[$i])) break;
        list($num,$date,$name,$email,$subj,$com,$url,
             $col,$icon,$type,,$host) = explode("<>", $result[$i]);
        list($color,$b_color) = explode(";", $col);
        if ($url != "") $url = "http://".$url;
        if ($icon != "") $icon = I_DIR.$icon;
        if ($type == 0) $oya = true;
        else $res = $type;
        // �e�L���i�[
        $arg['out'][] = compact('num','date','name','email','subj','com','b_color','color','icon','host','oya','res','over','page');
      }
      $arg['page_def'] = $page_def;
      $arg['st'] = $page + 1;
      $arg['to'] = $i;
      // �y�[�W�O/��
      $prev = $page - $page_def;
      $next = $i;
      if ($prev >= 0)          $arg['prev'] = "{$_SERVER['PHP_SELF']}?mode=s&w=$word&andor=$andor&log=$log&pp=$page_def&page=$prev";
      if ($next < count($result)) $arg['next'] = "{$_SERVER['PHP_SELF']}?mode=s&w=$word&andor=$andor&log=$log&pp=$page_def&page=$next";
      // �y�[�W���ڈړ�
      $tpage = ceil(count($result) / $page_def);
      for ($a = 0; $a < $tpage; $a++) {
        if ($a == $page/$page_def) $arg['paging'].= "[<b>$a</b>] ";
        else $arg['paging'].= "[<a href=\"{$_SERVER['PHP_SELF']}?mode=s&w=$word&andor=$andor&log=$log&pp=$page_def&page=$pp\"><b>$a</b></a>] ";
        $pp += $page_def;
      }
      if ($_GET['all'] == 1)       $arg['logname'] = "No.{$word} Display Posts";
      elseif ($_GET['logs'] == 0)  $arg['logname'] = "View Logs";
      elseif ($_GET['logs'])       $arg['logname'] = "Past $logs Search";
    }
  }
  $pastno = file(PASTLOG);
  for ($i = $pastno[0]; $i > 0; $i--) {
    $sel = ($_GET['logs'] == $i) ? " selected" : "";
    $arg['past'][] = array('no'=>$i,'sel'=>$sel);
  }
  $arg['search_mode'] = true;
  $arg['title'] = "Search";
  $arg['self'] = PHP_SELF;
  HtmlTemplate::t_include(OTHERFILE,$arg);
}
/*-- �ߋ����O�\�� --*/
function past_view($logs, $page) {
  if ($logs == "0") $logs = 1;
  if (file_exists(PASTDIR.$logs.".txt")) {
    $lines = file(PASTDIR.$logs.".txt");
    if (!$page) $page = 0;
    // �L���\��
    for ($i = $page; $i < $page+PASTDEF; $i++) {
      if (!trim($lines[$i])) break;
      list($num,$date,$name,$email,$subj,$com,$url,
           $col,$icon,$type,,$host) = explode("<>", $lines[$i]);
      list($color,$b_color) = explode(";", $col);
      if ($url != "") $url = "http://".$url;
      if ($icon != "") $icon = I_DIR.$icon;
      if ($type == 0) $oya = true;
      else $res = $type;
      // �e�L���i�[
      $arg['out'][] = compact('num','date','name','email','subj','com','b_color','color','icon','host','oya','res','over','page');
    }
    $arg['page_def'] = PASTDEF;
    $arg['st'] = $page + 1;
    $arg['to'] = $i;
    // �y�[�W�O/��
    $prev = $page - PASTDEF;
    $next = $i;
    if ($prev >= 0)          $arg['prev'] = "{$_SERVER['PHP_SELF']}?mode=log&logs=$logs&page=$prev";
    if ($next < count($lines)) $arg['next'] = "{$_SERVER['PHP_SELF']}?mode=log&logs=$logs&page=$next";
    // �y�[�W���ڈړ�
    $tpage = (int)count($lines) / PASTDEF;
    for ($a = 0; $a < $tpage; $a++) {
      if ($a == $page/PASTDEF) $arg['paging'].= "[<b>$a</b>] ";
      else $arg['paging'].= "[<a href=\"{$_SERVER['PHP_SELF']}?mode=log&logs=$logs&page=$pp\"><b>$a</b></a>] ";
      $pp += PASTDEF;
    }
    $arg['logname'] = "Past $logs Show";
    $arg['total'] = count($lines);
  }
  else {
    $arg['logname'] = "Log cannot be found.";
  }
  $pastno = file(PASTLOG);
  for ($i=$pastno[0],$j=0; $i>0,$j<$pastno[0]; $i--,$j++) {
    $arg['past'][$j]['no'] = $i;
    $arg['past'][$j]['link'] = ($logs == $i) ? "" : true;
    if (($j % 4)==3) $arg['past'][$j]['br'] = "<br>";
  }
  $arg['logs'] = $logs;
  $arg['past_mode'] = true;
  $arg['title'] = "Display past logs.";
  $arg['self'] = PHP_SELF;
  HtmlTemplate::t_include(OTHERFILE,$arg);
}
/*-- �ߋ����O������ --*/
function past_write($lines) {
  // �ߋ����ONo�ǂݍ���
  $fp = fopen(PASTLOG, "r");
  $cnt = fgets($fp, 10);
  fclose($fp);
  $pfile = PASTDIR . $cnt . ".txt";
  if (file_exists($pfile)) {
    // �ߋ����O�T�C�Y�I�[�o�[�Ȃ�ߋ����ONo�A�b�v
    if (filesize($pfile) > PASTSIZE*1024) {
      $cnt++;
      $fp = fopen(PASTLOG, "w");
      set_file_buffer($fp, 0);
      flock($fp, LOCK_EX);
      fputs($fp, $cnt);
      fclose($fp);
      $pfile = PAST_DIR . $cnt . ".txt";
    }
  }
  // �ߋ����O�ɏ�����
  $fp = fopen($pfile, "a");
  set_file_buffer($fp, 0);
  flock($fp, LOCK_EX);
  fputs($fp, implode('', $lines));
  fclose($fp);
}
/*-- ���O�X�V --*/
function update($lines) {
  $fp = fopen(LOGFILE, "w");
  set_file_buffer($fp, 0);
  flock($fp, LOCK_EX);
  fputs($fp, implode('', $lines));
  fclose($fp);
}
/*-- ���������N --*/
function autolink($str) {
    return ereg_replace("(https?|ftp)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)","<a href=\"\\1\\2\" target=_top>\\1\\2</a>",$str);
}
/*-- �Í����֐� --*/
function my_crypt($str) {
  $time = time();
  list($p1, $p2) = unpack("C2", $time);
  $wk = $time / (7*86400) + $p1 + $p2 - 8;
  $saltset = array_merge(range('a', 'z'),range('A', 'Z'),range('0', '9'),array('/'));
  return $saltset[$wk % 64] . $saltset[$time % 64];
}
/*-- �G���[�\�� --*/
function error($str) {
  $arg['error'] = $str;
  $arg['err_mode'] = true;
  $arg['title'] = "Error!";
  $arg['self'] = PHP_SELF;
  HtmlTemplate::t_include(OTHERFILE,$arg);
  exit;
}
/*-- �f�o�O --*/
function _dbg($str) {
  echo "<pre>";
  var_export($str);
  echo "</pre>";
}
// �X�^�[�g�I
$page = intval($_GET['page']);
$mode = ($_GET['mode']) ? $_GET['mode'] : $_POST['mode'];

switch ($mode) {
  // ������
  case 'write':
    $data = check();
    log_write($data);
    header("Location: $jump");
  //echo "<META HTTP-EQUIV=\"refresh\" content=\"0;URL=".PHP_SELF."?\">";
    break;
  // �폜
  case 'del':
    del();
    header("Location: $jump");
    //echo "<META HTTP-EQUIV=\"refresh\" content=\"0;URL=".PHP_SELF."?\">";
    break;
  // �ҏW
  case 'edit':
    edit();
    break;
  // �ҏW������
  case 'rewrite':
    $data = check();
    rewrite($data, intval($_POST['num']));
    echo "<META HTTP-EQUIV=\"refresh\" content=\"0;URL=".PHP_SELF."?\">";
    break;
  // �Ǘ�
  case 'admin':
    all_view($page, "admin");
    break;
  // ���X�\��
  case 'res':
    res_view(intval($_GET['num']));
    break;
  // ����
  case 's':
    search();
    break;
  // �ߋ����O�\��
  case 'log':
    past_view(intval($_GET['logs']), $page);
    break;
  // �A�C�R���ꗗ
  case 'img':
    $l=1;
    foreach ($html_icon as $key=>$val) {
      if ($key == "randam") continue;
      if ($key == "master") $key = $mas_i[0];
      $arg['icon'][] = array('file' => I_DIR.$key, 'name' => $val);
      if (($l % $Ico_h)==0) $arg['icon'][$l-1]['tr'] = "</tr><tr>";
      $l++;
    }
    $arg['img_mode'] = true;
    $arg['title'] = "Icon Image List";
    $arg['self'] = PHP_SELF;
    HtmlTemplate::t_include(OTHERFILE,$arg);
    break;
  // �w���v�\��
  case 'man':
    $arg['man_mode'] = true;
    $arg['title'] = "How to use CKIB";
    $arg['maxlog'] = MAXLOG;
    $arg['self'] = PHP_SELF;
    HtmlTemplate::t_include(OTHERFILE,$arg);
    break;
  // �V�K���e�ʉ��
  case 'post':
    $arg['post_mode'] = true;
    $arg['title'] = "New";
    $arg['font'] = radio_list("font");
    $arg['hr']   = radio_list("hr");
    $arg['icon'] = option_list();
    $arg['maxcom'] = MAXCOM;
    $arg['self'] = PHP_SELF;
    HtmlTemplate::t_include(OTHERFILE,$arg);
    break;
  // �ʏ�\��
  default:
    all_view($page);
}
?>
