<?php
    ini_set('display_errors', 'Off');
    error_reporting(0);
    date_default_timezone_set("Asia/Makassar");
    session_start();
    require_once 'Model.php';
    require_once 'View.php';
    require_once 'TanggalIndo.php';
    Class Control{
        public $model, $view, $tanggalIndo, $auditing;
        public $_ID_ = "unitZarindah_id";  
        public $_AKSES_ = "unitZarindah_status"; 
        public $_PAGE = "page_content_unitZarindah";  
        public $_BASE_URL = "localhost/unitZarindah/"; 
        
        public function __construct() {
            $this->model = new Model();
            $this->view = new View();
            $this->tanggalIndo = new TanggalIndo();
        }
        
        //Elementary------------------------------------------------------------
        public function setSession($var, $data){
            $_SESSION[$var] = $data;
        }
        public function setDeleteSession($var){
            unset($_SESSION[$var]);
        }        
        public function getSession($var){
            return @$_SESSION[$var]; 
        }
        public function getIssetSession($var){
            return isset($_SESSION[$var]); 
        }
        public function getText($textSource){
            //return trim(str_replace("--", "", str_replace("=", "", str_replace("'", "\'", $textSource))));
            return str_replace("--", "", str_replace("'", "\'", $textSource));
        }
        public function getText2($textSource){
            return str_replace("--", "", str_replace("'", "\'", $textSource));
        }
        public function getTextStripTag($textSource){
            return str_replace("--", "", str_replace("=", "", str_replace("'", "\'", strip_tags($textSource))));
        }
        public function getStripTag($textSource){
            return str_replace("'", "\'", strip_tags($textSource,'<ul><ol><li><b><u><i><strong><a><img><br><p><table><tr><td><th>'));
        }
        public function numerikToText($textSource){
            $return = str_replace(",", ".", str_replace(".", "", strip_tags($textSource)));
            if (trim($return)=="") $return = 0;
            return $return;
        }
        public function getRecQuote($textSource){            
            return str_replace('\"', '"', str_replace("\'", "'", $textSource));
        }
        public function getDescMonth($b){
            $arrBulan = ['','Januari','Februari','Maret','April','Mei','Juni',
                         'Juli','Agustus','September','Oktober','November','Desember'];
            return $arrBulan[intval($b)];
        }
        public function getListMonth(){
            return [(object) ['value'=>'1','title'=>'Januari'],
                    (object) ['value'=>'2','title'=>'Februari'],
                    (object) ['value'=>'3','title'=>'Maret'],
                    (object) ['value'=>'4','title'=>'April'],
                    (object) ['value'=>'5','title'=>'Mei'],
                    (object) ['value'=>'6','title'=>'Juni'],
                    (object) ['value'=>'7','title'=>'Juli'],
                    (object) ['value'=>'8','title'=>'Agustus'],
                    (object) ['value'=>'9','title'=>'September'],
                    (object) ['value'=>'10','title'=>'Oktober'],
                    (object) ['value'=>'11','title'=>'November'],
                    (object) ['value'=>'12','title'=>'Desember']];
        }
        public function randomString($length) {
            $str = "";
            $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
            $max = count($characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                    $rand = mt_rand(0, $max);
                    $str .= $characters[$rand];
            }
            return $str;
        }
        public function getRandomString($length) {
            $str = "";
            $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
            $max = count($characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                    $rand = mt_rand(0, $max);
                    $str .= $characters[$rand];
            }
            return $str;
        }
        public function numberToRomanRepresentation($number) {
            $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
            $returnValue = '';
            while ($number > 0) {
                foreach ($map as $roman => $int) {
                    if($number >= $int) {
                        $number -= $int;
                        $returnValue .= $roman;
                        break;
                    }
                }
            }
            return $returnValue;
        }
        public function smart_wordwrap($string, $width = 75, $break = "<br>") {
            $pattern = sprintf('/([^ ]{%d,})/', $width);
            $output = '';
            $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            foreach ($words as $word) {
                if (false !== strpos($word, ' ')) {
                    $output .= $word;
                } else {
                    $wrapped = explode($break, wordwrap($output, $width, $break));
                    $count = $width - (strlen(end($wrapped)) % $width);
                    $output .= substr($word, 0, $count) . $break;
                    $output .= wordwrap(substr($word, $count), $width, $break, true);
                }
            }
            return wordwrap($output, $width, $break);
        }
        public function random_color_part() {
            return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
        }
        public function random_color() {
            return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
        }
        //End Elementary-------------------------------------------------------
        
        //Account---------------------------------------------------------------
        public function getLogin($username, $password){
            $rAkun = $this->model->getListQuery("SELECT id, password FROM akun WHERE (username='".$this->getText($username)."') ", 
                                                ['id','password']);
            $cek = FALSE;
            if ((count($rAkun)>0) && ($rAkun[0]->password == $password)){
                $this->setSession($this->_ID_,$rAkun[0]->id);
                $cek = TRUE;
            }
            return $cek;
        }
        public function getLoginMobile($username, $password){
            $rAkun = $this->model->getListQuery("SELECT id, password FROM akun 
                                                 WHERE (username='".$this->getText($username)."') ", 
                                                ['id','password']);
            $cek = FALSE;
            if ((count($rAkun)>0) && ($rAkun[0]->password == $password)){
                $this->setSession($this->_ID_,$rAkun[0]->id);
                $cek = TRUE;
            }
            return $cek;
        }
        public function getStatusLogin(){
            $account = $this->model->getListQuery("SELECT id FROM akun 
                                                   WHERE (id='".$this->getSession($this->_ID_)."')",
                                                   ['id']);
            return (count($account)>0) ? TRUE : FALSE;
        }
        public function getDataAkun(){
            $r = $this->model->getListQuery("SELECT id, nama, email, nohp, username, password
                                             FROM akun
                                             WHERE (id = '".$this->getSession($this->_ID_)."')", 
                                             ['id', 'nama', 'email', 'noHp', 'username', 'password']);
            return $r[0];
        }
        public function setLogout(){
            unset($_SESSION[$this->_ID_]);
            unset($_SESSION[$this->_PAGE]); 
        }
        //End Account-----------------------------------------------------------
        
        //Tabel-----------------------------------------------------------------
        public function getContentField($field,$fieldId,$id,$table){
            $r = $this->model->getListQuery("SELECT ".$this->getText($field)." FROM ".$this->getText($table)." WHERE ".$this->getText($fieldId)."='".$this->getText($id)."'", array($field));
            return $r[0]->$field;
        }
        public function getRowDataById($tableName,$arrField,$id, $fieldId){
            $field = implode(",", $arrField);
            $r = $this->model->getListQuery("SELECT ".$field." FROM ".$tableName." WHERE ".$fieldId."='". $this->getText($id)."'", $arrField);
            return $r;
        }
        public function getRowData($tableName,$arrField,$arrFieldSelection,$arrDataSelection,$orderBy,$orderByStatus,$groupBy){
            $field = implode(",", $arrField);
            if (count($arrFieldSelection)>0){
                $selection = "WHERE ";
                for ($i=0;$i<count($arrFieldSelection);$i++){
                    $selection .= ($selection=="WHERE ") ? " (".$arrFieldSelection[$i]."='".$arrDataSelection[$i]."') " : " AND (".$arrFieldSelection[$i]."='".$arrDataSelection[$i]."')";
                }
            }
            if ($orderBy!=""){ $orderBy = " ORDER BY ".$orderBy." ".$orderByStatus; } 
            if ($groupBy!=""){ $groupBy = " ORDER BY ".$groupBy; } 
            $r = $this->model->getListQuery("SELECT ".$field." FROM ".$tableName." ".$selection." ".$groupBy." ".$orderBy, $arrField);
            return $r;
        }
        public function getRowDataLabel($tableName,$arrField,$arrLabel,$arrFieldSelection,$arrDataSelection,$orderBy,$orderByStatus,$groupBy){
            $field = implode(",", $arrField);
            if (count($arrFieldSelection)>0){
                $selection = "WHERE ";
                for ($i=0;$i<count($arrFieldSelection);$i++){
                    $selection .= ($selection=="WHERE ") ? " (".$arrFieldSelection[$i]."='".$arrDataSelection[$i]."') " : " AND (".$arrFieldSelection[$i]."='".$arrDataSelection[$i]."')";
                }
            }
            if ($orderBy!=""){ $orderBy = " ORDER BY ".$orderBy." ".$orderByStatus; } 
            if ($groupBy!=""){ $groupBy = " GROUP BY ".$groupBy; } 
            $r = $this->model->getListQuery("SELECT ".$field." FROM ".$tableName." ".$selection." ".$groupBy." ".$orderBy, $arrLabel);
            return $r;
        }
        public function getRowDataLimit($tableName,$arrField,$arrFieldSelection,$arrDataSelection,$orderBy,$orderByStatus,$groupBy,$limit){
            $field = implode(",", $arrField);
            if (count($arrFieldSelection)>0){
                $selection = "WHERE ";
                for ($i=0;$i<count($arrFieldSelection);$i++){
                    $selection .= ($selection=="WHERE ") ? " (".$arrFieldSelection[$i]."='".$arrDataSelection[$i]."') " : " AND (".$arrFieldSelection[$i]."='".$arrDataSelection[$i]."')";
                }
            }
            if ($orderBy!=""){ $orderBy = " ORDER BY ".$orderBy." ".$orderByStatus; } 
            if ($groupBy!=""){ $groupBy = " ORDER BY ".$groupBy; } 
            if ($limit!=""){ $limit = " LIMIT ".$limit; } 
            $r = $this->model->getListQuery("SELECT ".$field." FROM ".$tableName." ".$selection." ".$groupBy." ".$orderBy." ".$limit, $arrField);
            return $r;
        }
        public function getRowDataFieldAlias($tableName,$arrField,$arrFieldAlias,$arrFieldSelection,$arrDataSelection,$orderBy,$orderByStatus,$groupBy){
            $field = implode(",", $arrField);
            if (count($arrFieldSelection)>0){
                $selection = "WHERE ";
                for ($i=0;$i<count($arrFieldSelection);$i++){
                    $selection .= ($selection=="WHERE ") ? " (".$arrFieldSelection[$i]."='".$arrDataSelection[$i]."') " : " AND (".$arrFieldSelection[$i]."='".$arrDataSelection[$i]."')";
                }
            }
            if ($orderBy!=""){ $orderBy = " ORDER BY ".$orderBy." ".$orderByStatus; } 
            if ($groupBy!=""){ $groupBy = " ORDER BY ".$groupBy; } 
            $r = $this->model->getListQuery("SELECT ".$field." FROM ".$tableName." ".$selection." ".$groupBy." ".$orderBy, $arrFieldAlias);
            return $r;
        }
        public function getDeleteData($tableName, $fieldId, $id){
            $checkUpdate = $this->model->getExeQuery("DELETE FROM ".$tableName." WHERE (".$fieldId."='".$id."')");
            return $checkUpdate;
        }
        public function setDelete($tableName, $fieldId, $id_, $divPesan){
            $this->model->setStartTransaction();
            $id = $this->getText($id_);
            $checkUpdate = $this->getDeleteData($tableName, $fieldId, $id);
            if ($checkUpdate){
                $this->model->setCommit();
                $this->view->setJs("top.".$this->view->getNotificationFloat("success","Data telah dihapus !").
                                   "top.".$this->getSession($this->_PAGE));
            }else{
                $this->model->setRollBack();
                $this->view->setJs("top.".$this->view->getNotification("danger","Data gagal dihapus !", $divPesan));
            }
        }
        public function setDeletePage($tableName, $fieldId, $id_, $page, $divPesan){
            $this->model->setStartTransaction();
            $id = $this->getText($id_);
            $checkUpdate = $this->getDeleteData($tableName, $fieldId, $id);
            if ($checkUpdate){
                $this->model->setCommit();
                $this->view->setJs("top.".$this->view->getNotificationFloat("success","Data telah dihapus !").
                                   "top.".$page);
            }else{
                $this->model->setRollBack();
                $this->view->setJs("top.".$this->view->getNotification("danger","Data gagal dihapus !", $divPesan));
            }
        }
        public function setDeleteRow($tableName, $fieldId, $arrId, $divPesan){
            $this->model->setStartTransaction();
            $checkUpdate = TRUE;
            for ($i=0;$i<count($arrId);$i++){
                $id = $this->getText($arrId[$i]);
                $checkUpdate = $this->getDeleteData($tableName, $fieldId, $id);
                if (!($checkUpdate)) break;
            }
            if(count($arrId)==0){
                $this->model->setRollBack();
                $this->view->setJs("top.".$this->view->getNotification("danger","Pilih Data terlebih dahulu !", $divPesan));
            }elseif ($checkUpdate){
                $this->model->setCommit();
                $this->view->setJs("top.".$this->view->getNotificationFloat("success","Data telah dihapus !").
                                   "top.".$this->getSession($this->_PAGE));
            }else{
                $this->model->setRollBack();
                $this->view->setJs("top.".$this->view->getNotification("danger","Data gagal dihapus !", $divPesan));
            }
        }
        public function getCheckValueUnique($table,$fieldId,$valueId,$fieldUnique,$valueUnique){
            $r = $this->model->getListQuery("SELECT COUNT(". $this->getText($fieldId).") FROM ".$table."
                                             WHERE (". $this->getText($fieldId)."<>'". $this->getText($valueId)."') AND 
                                                   (". $this->getText($fieldUnique)."='". $this->getText($valueUnique)."') ",
                                             ['c']);
            return (intval($r[0]->c)>0) ? TRUE : FALSE ;
        }
        public function getLastId($table, $fielId){
            $r = $this->model->getListQuery("SELECT ".$fielId." FROM ".$table." ORDER BY id DESC LIMIT 0,1 ", 
                                            ['id']);
            return (count($r)>0) ? $r[0]->id : 0;
        }
        public function getCheckDataUniq($table, $field, $data, $id, $fieldId){
            $r = $this->model->getListQuery("SELECT COUNT(".$field.") FROM ".$table." WHERE (".$field."='".$this->getText($data)."') AND (".$fieldId."<>'". $this->getText($id)."')", 
                                             ['c']);
            return (intval($r[0]->c)==0) ? FALSE : TRUE;
        }
        public function getCheckDataExist($table, $id, $fieldId){
            $r = $this->model->getListQuery("SELECT ".$fieldId." FROM ".$table." WHERE (".$fieldId." = '". $this->getText($id)."')", 
                                             ['c']);
            return (intval($r[0]->c)==0) ? FALSE : TRUE;
        }
        public function getInsertData($tableName, $arrField, $arrData){
            $field = implode(",", $arrField);
            $data = "";
            for ($i=0;$i<count($arrData);$i++) $data .= ($data=="") ? "'". $this->getText($arrData[$i])."'" : ",'".$this->getText($arrData[$i])."'";
            $checkUpdate = $this->model->getExeQuery("INSERT INTO ".$tableName."(".$field.") VALUES(".$data.")");
            return $checkUpdate;
        }
        public function getUpdateData($tableName, $arrField, $arrData, $id, $fieldId){
            $fieldData = "";
            for ($i=0;$i<count($arrData);$i++) $fieldData .= ($fieldData=="") ? $this->getText($arrField[$i])."='".$this->getText($arrData[$i])."'" : ",".$this->getText($arrField[$i])."='".$this->getText($arrData[$i])."'";
            $checkUpdate = $this->model->getExeQuery("UPDATE ".$tableName." SET ".$fieldData." WHERE (".$fieldId."='".$id."') ");
            return $checkUpdate;
        }
        public function setInsertUpdate($action, $tableName, $arrField, $arrData, $id, $fieldId, $divMessage, $page){
            $this->model->setStartTransaction();
            if ($action=="add"){
                $checkUpdate = $this->getInsertData($tableName, $arrField, $arrData);
            }else{
                $checkUpdate = $this->getUpdateData($tableName, $arrField, $arrData, $id, $fieldId);
            }
            if ($checkUpdate){
                $this->model->setCommit();
                $this->view->setJs("top.".$this->view->getNotificationFloat("success","Data telah diperbaharui !").
                                   "top.".$page);
            }else{
                $this->model->setRollBack();
                $this->view->setJs("top.".$this->view->getNotification("danger","Data gagal diperbaharui !", $divMessage));
            }
        }
        public function setInsertUpdateNoBack($action, $tableName, $arrField, $arrData, $id, $fieldId, $divMessage, $page){
            $this->model->setStartTransaction();
            if ($action=="add"){
                $checkUpdate = $this->getInsertData($tableName, $arrField, $arrData);
            }else{
                $checkUpdate = $this->getUpdateData($tableName, $arrField, $arrData, $id, $fieldId);
            }
            if ($checkUpdate){
                $this->model->setCommit();
                $this->view->setJs("top.".$this->view->getNotification("success","Data telah diperbaharui !", $divMessage));
            }else{
                $this->model->setRollBack();
                $this->view->setJs("top.".$this->view->getNotification("danger","Data gagal diperbaharui !", $divMessage));
            }
        }
        //End Tabel-------------------------------------------------------------
        
        //Upload----------------------------------------------------------------
        public function getUploadFile($path_name_, $name_, $location, $filter, $arrFilter){
            $pathFile = $path_name_;
            $namaFile = $name_;

            $tmp = explode(".",$namaFile);
            $type = strtolower($tmp[count($tmp)-1]);
            $con = true;
            if ($filter){
                $retFilter = FALSE;
                for ($i=0;$i<count($arrFilter);$i++){
                    if (strtolower($arrFilter[$i])== strtolower($type)){
                        $retFilter = TRUE;
                        break;
                    }
                }
                if (!$retFilter){
                    $con  = FALSE;
                    return array('status'=>FALSE,'namaFile'=>'','keterangan'=>"Tipe File harus ".implode(" / ", $arrFilter)." !");
                }
            }
            if (($pathFile!="")&&($pathFile!=NULL)){
                $file = md5(date("Ymd").date("His",time()).rand(000,999)).".".$type;
                $check = move_uploaded_file($pathFile, $location.$file);
                if ($check){
                    return array('status'=>TRUE,'namaFile'=>$file,'keterangan'=>"Upload File sukses !");
                }else{    
                    return array('status'=>FALSE,'namaFile'=>'','keterangan'=>"Upload file gagal, silahkan ulangi !");
                }
            }else{
                return array('status'=>FALSE,'namaFile'=>'','keterangan'=>"Pilih file terlebih dahulu !");
            }
        }
        public function getUploadFileCustom($path_name_, $name_, $location, $filter, $arrFilter){
            $pathFile = $path_name_;
            $namaFile = $name_;

            $tmp = explode(".",$namaFile);
            $type = strtolower($tmp[count($tmp)-1]);
            $con = true;
            if ($filter){
                $retFilter = FALSE;
                for ($i=0;$i<count($arrFilter);$i++){
                    if (strtolower($arrFilter[$i])== strtolower($type)){
                        $retFilter = TRUE;
                        break;
                    }
                }
                if (!$retFilter){
                    $con  = FALSE;
                    return array('status'=>FALSE,'namaFile'=>'','keterangan'=>"Tipe File harus ".implode(" / ", $arrFilter)." !");
                }
            }
            if (($pathFile!="")&&($pathFile!=NULL)){
                $file = $name_;
                $check = move_uploaded_file($pathFile, $location.$file);
                if ($check){
                    return array('status'=>TRUE,'namaFile'=>$file,'keterangan'=>"Upload File sukses !");
                }else{    
                    return array('status'=>FALSE,'namaFile'=>'','keterangan'=>"Upload file gagal, silahkan ulangi !");
                }
            }else{
                return array('status'=>FALSE,'namaFile'=>'','keterangan'=>"Pilih file terlebih dahulu !");
            }
        }
        public function uploadFile($lokasiFile, $namaFile, $arrTipe, $act, $lastData, $divMessage){
            if (($lokasiFile!=NULL)&&($lokasiFile!="")){
                $upload = $this->getUploadFile($lokasiFile, $namaFile, "./assets/kawasan/", 
                                               true, $arrTipe);
                if (!$upload['status']){
                    $this->view->setJs("top.".$this->view->getNotification("danger",$upload['keterangan'], $divMessage));
                    exit;
                }else{
                    $file = $upload['namaFile'];
                    if ($act=="edit"){
                        if (is_file("./assets/kawasan/".$lastData)) unlink ("./assets/kawasan/".$lastData);
                    }
                }
            }else{
                $file = ($act=="edit") ? $lastData : "";
            }
            return $file;
        }
        
        public function uploadFileCustom($lokasiFile, $namaFile, $destination, $arrTipe, $act, $lastData, $divMessage){
            if (($lokasiFile!=NULL)&&($lokasiFile!="")){
                $upload = $this->getUploadFileCustom($lokasiFile, $namaFile, $destination, 
                                               true, $arrTipe);
                if (!$upload['status']){
                    $this->view->setJs("top.".$this->view->getNotification("danger",$upload['keterangan'].$namaFile, $divMessage));
                    exit;
                }else{
                    $file = $upload['namaFile'];
                    if ($act=="edit"){
                        if (is_file($destination.$lastData)) unlink ($destination.$lastData);
                    }
                }
            }else{
                $file = ($act=="edit") ? $lastData : "";
            }
            return $file;
        }
        //end Upload------------------------------------------------------------
        
        //Page------------------------------------------------------------------
        public function getPageData($title, $listTitle, $data, $folder, $file, $table, $focus){
            return "call('".$title."', '".$this->view->getListTitle($listTitle)."', 'page/".$folder."/".$file."', ".$data.", '".$table."', 'page/".$folder."/table', ".$focus.")";
        }
        public function getPageDataTable($title,$folder, $file, $data, $table, $fileTable){
            return "callTable('".$title."', '".$folder."', '".$file."', '".$data."', '".$table."', '".$fileTable."');";
        }
        public function getPage($title, $folder, $table, $focus){
            return "call('".$title."', '".$folder."', 'index', '', '".$table."', '".$focus."');";
        }
        public function getPageForm($title, $act, $folder, $focus){
            return "call('".$title."', '".$folder."', 'form', 'act=".$act."', null, '".$focus."');";
        }
        public function getPageFile($title, $folder, $file, $data, $focus){
            return "call('".$title."', '".$folder."', '".$file."', '".$data."', null, '".$focus."');";
        }
        public function setCallPage($title, $folder, $table, $focus){
            return $this->setSession($this->_PAGE, $this->getPage($title, $folder, $table, $focus));
        }
        public function encrypt_url($string) {
            $key = "unitZarindah"; 
            $result = '';
            $test = "";
            for($i=0; $i<strlen($string); $i++) {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)+ord($keychar));
                $test[$char]= ord($char)+ord($keychar);
                 $result.=$char;
            }
            return urlencode(base64_encode($result));
        }
        public function decrypt_url($string) {
            $key = "unitZarindah"; 
            $result = '';
            $string = base64_decode(urldecode($string));
            for($i=0; $i<strlen($string); $i++) {
               $char = substr($string, $i, 1);
               $keychar = substr($key, ($i % strlen($key))-1, 1);
               $char = chr(ord($char)-ord($keychar));
               $result.=$char;
            }
            return $result;
        }
        public function getCurrentUrl($s, $varReport, $use_forwarded_host=false){
            $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
            $sp = strtolower($s['SERVER_PROTOCOL']);
            $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
            $port = $s['SERVER_PORT'];
            $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
            $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
            $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
            return $protocol . '://' . $host. "/eoffice/scan?code=".$varReport;
        }
        
        //End Page--------------------------------------------------------------
        
        public function setShow($content){
            echo $content;
        }
        
        public function getConvertDate($tgl){
            $tmp = explode("/", $tgl);
            return $tmp[2]."-".$tmp[1]."-".$tmp[0];
        }
        public function getShowDate($tgl){
            $tmp = explode("-", $tgl);
            return $tmp[2]."/".$tmp[1]."/".$tmp[0];
        }
        
        public function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp =$this->penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp =$this->penyebut($nilai/10)." Puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" .$this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp =$this->penyebut($nilai/100) . " Ratus" .$this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" .$this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp =$this->penyebut($nilai/1000) . " Ribu" .$this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp =$this->penyebut($nilai/1000000) . " Juta" .$this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp =$this->penyebut($nilai/1000000000) . " Milyar" .$this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp =$this->penyebut($nilai/1000000000000) . " Trilyun" .$this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	public function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "Minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}       
        
        public function getPageInfo($dir){
            $title = ['beranda'=>'Beranda',
                      'kawasan'=>'Peta Kawasan Terdampak',
                      'waypoint'=>'waypoint',
                      'shelter'=>'Shelter',
                      'cariShelter'=>'Telusuri Rute Shelter Terbaik',
                      'akun'=>'Akun Anda'];
            $focus = [''=>''];
            return ['title'=>$title[$dir],'focus'=>$focus[$dir]];
        }
}
?>
