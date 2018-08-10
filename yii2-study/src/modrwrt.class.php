<?php

class ModRewrite {
    
    /**
     * @var array contains all mysql data and added indexes of the GET-Vars
     * array(
     * ['news'] =>  array(
     *                  ['action'] => 0,
     *                  ['newsID'] => 1,
     *              ),
     * ['...'] => array( ... )
     * )
     */
    
    private $key_indexes = array();
    public $uri;
    
    
    /**
     * contructor calls $this->mysql_getKeyIndexes once for indexes from table "modrwrt"
     */
    
    function __construct() {
        $this->mysql_getKeyIndexes();
    }
    
    /**
     * called by ob_start
     * @param string $buffer The given string from ob_start
     * @return string Parsed string with rewritten URL
     */
    
    public function outBuffer($buffer) {
        return preg_replace_callback('/["\'=]\bindex\.php\?\b[^"\']+/',array($this,'parseUrl'),$buffer);  
    }
    
    /**
     * fetches all indexes for all GET keys from table PREFIX.modrwrt and puts them in var $this->key_indexes
     */
    
    private function mysql_getKeyIndexes() {
        $q = safe_query("SELECT `index`,`var`,`site` FROM `".PREFIX."modrwrt` ORDER BY `index`,`site` ASC");
        $cur_site = '';
        while($res = mysql_fetch_array($q)) {
            $this->key_indexes[$res['site']][$res['var']] = $res['index'];
        }
    }
    
    /**
     * when there was no index for the key, den there will be a new one registered for it with the highest index
     * @param string $site the index.php?site= value
     * @param string $key the key like index.php?site=news&_action_=archive
     * @return int the new index of the key
     */
    
    private function mysql_registerNewKey($site,$key = false) {
        $lastindex_q = safe_query("SELECT `index` FROM ".PREFIX."modrwrt WHERE `site`='".$site."' ORDER BY `index` DESC LIMIT 0,1");
        
        if(mysql_num_rows($lastindex_q)) {
            $lastindex_res = mysql_fetch_array($lastindex_q);
            $lastindex = $lastindex_res['index']+1;
        }
        else {
            $lastindex = 0;
        }
        $this->key_indexes[$site][$key] = $lastindex;
        safe_query("INSERT INTO ".PREFIX."modrwrt(`site`,`index`,`var`) VALUES('$site',$lastindex,'$key')");
        return $lastindex;
    }
    
    /**
     * parser called from outBuffer()
     * @param array $url array with only one element containing the url#
     * @return string the rewritten URL
     */
    
    private function parseUrl($url) {
    	global $hp_url;
    	
        $start = substr($url[0],0,1);
        $url = substr($url[0],11);  // ENTFERNT "index.php?
        $url = str_replace('&amp;','&',$url);   // URLS NORMALISIEREN - ALLE auf das unschöne & anstatt &amp; - anstatt regexp auf &amp;
        
        
        $url_split = explode("&",$url);
        $values = array();

        foreach($url_split as $keynvalue) {
            list($key,$value) = explode("=",$keynvalue);
            if($key == 'site') {
                $cur_site = $value;
                $index = 0;
            }
            else {   
                if(!isset($this->key_indexes[$cur_site][$key])) {
                    $index = $this->mysql_registerNewKey($cur_site,$key)+1;
                }
                else $index = $this->key_indexes[$cur_site][$key]+1;
            }
            $values[$index] = $value;
        }
        $indexes = array_values($this->key_indexes[$cur_site]);
        for($i=1;$i<count($indexes);$i++) {
            if(!isset($values[$i])) $values[$i] = '-';
        }
        krsort($values);
        foreach($values as $key => $val) {
            if($val == '-') unset($values[$key]);
                else break;
        }
        ksort($values);
        $final_url =  implode(MODRWRT_SEP,$values).MODRWRT_ADDITIONAL;
        
        return $start.($start == '=' ? 'http://'.$hp_url.'/' : '').$final_url;
    }
    
    
    /**
     * END URL REWRITE
     * START PARSING OPENED URL
     */
    
    
    /**
     * Parses the current site.com/var1/var2/var3/ -like URL and sets the $_GET vars
     * @return string current site
     */
    
    public function parseCurrentUrl() {
        $req_uri = str_replace(MODRWRT_ADDITIONAL,'/',str_replace(MODRWRT_SEP,'/',$_SERVER['REQUEST_URI']));
        $uri_a = explode('/',$req_uri);
        
        $path = str_replace('\\','/',dirname(dirname(__FILE__)));    // WINDOWS \\ replacement
        $path_a = explode('/',$path);
        
        $uri = $this->filter_folder($path_a,$uri_a);
        if(file_exists($uri[count($uri)-1]) && !is_dir($uri[count($uri)-1])) return '';
        
        if(is_array($uri)) $this->uri = implode('/',$uri);
            else $this->uri = '';
        $starts_bad = $this->check_start($uri[0]);
            
        if($uri !== false && $starts_bad === false) {
            $site = array_shift($uri);
            $_GET['site'] = $site;
            if(isset($this->key_indexes[$site])) {
                $indexes = $this->swap_key_val($this->key_indexes[$site]);
                foreach($uri as $index => $value) {
                    if($value !== '-')
                        $_GET[$indexes[$index]] = $value;
                        $_REQUEST[$indexes[$index]] = $value;
                }
            }
            return $site;
        }
        else {
            return isset($_GET['site']) ? $_GET['site'] : '';
        }
    }
    
    
    /**
     * checks for URI starts, when no parsing is needed like index.php? or just ?
     * @param string $uri_start the url
     * @return bool if there was found a bad start or not
     */
    private function check_start($uri_start) {
        $bad_starts = array('index.php','?','admin');
        $found = false;
        foreach($bad_starts as $check) {
            $start = substr($uri_start,0,strlen($check));
            if($start == $check) {
                $found = true;
                break;
            }
        }
        return $found;
    }
    
    
    /**
     * @param string $path the current path
     * @param string $uri the current uri
     * @return string|bool when there is still something left from the uri the rest of it, else just false (bool)
     */
    private function filter_folder($path,$uri) {
        
        if($path[count($path)-1] == "") array_pop($path);
        if($uri[count($uri)-1] == "") array_pop($uri);
        
        $this->remove_empty($path);
        $this->remove_empty($uri);
        
        //echo implode("/",$path).'<br />';
        //echo implode("/",$uri);
        
        $found = false;
        
        $len = count($uri);
        $i = 1;
        while($i <= $len) {
            $check = array_slice($uri,0,$i);
            $check2 = array_slice($path,$i*-1,$i);
            if(implode("/",$check) == implode("/",$check2)) {
                $uri = array_slice($uri,$i);
                break;
            }
            $i++;
        }
        
        
        return count($uri) ? (array) array_values($uri) : (bool) false; // IST NOCH WAS ÜBRIG VON DER URL?
    }
    
    private function remove_empty(& $array) {
        foreach($array as $key => $val) {
            if(empty($val)) unset($array[$key]);
        }
    }
    
    /**
     * sometimes you need key and value of the keyindexes the other way around
     * ! may thorows error, if the value is no valide key name - but should normaly be an integer
     * @param array $array the array to change
     * @return array the changed array
     */
    
    private function swap_key_val($array){
        $ret = array();
        while(list($key,$val) = each($array))
            $ret[(int) $val] = (string) $key;
        return $ret;
    }
    
}

?>