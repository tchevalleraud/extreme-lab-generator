<?php
    namespace App;

    use phpseclib3\Net\SFTP;

    class Config {

        private $data;
        private $directory;

        public function __construct($directory = "./"){
            $this->createWritableFolder($directory);
            $this->directory = $directory;
        }

        public function addLine($line){
            $this->data[] = $line;
        }

        public function export($filename){
            $f = fopen($this->directory.$filename, "w+");
            foreach ($this->data as $d){
                fputs($f, $d."\n");
            }
            fclose($f);
        }

        public function exportData(){
            return $this->data;
        }

        public function importData($data){
            $this->data = $data;
        }

        public function reset(){
            $this->data = null;
        }

        public function upload($server, $login, $password, $dsc_folder = "/"){
            $sftp = new SFTP($server);
            $sftp->login($login, $password);
            foreach (scandir($this->directory) as $file){
                if($file == "." || $file == ".."){

                } else {
                    $sftp->put($dsc_folder.$file, $this->directory.$file, SFTP::SOURCE_LOCAL_FILE);
                    echo $server." | ".$this->directory.$file." -> ".$dsc_folder.$file." => ok\n";
                }
            }
        }

        private function createWritableFile($file){
            if (file_exists($file)) {
                return is_writable($file);
            }
            if($this->createWritableFolder(dirname($file)) && ($handle = fopen($file, 'w+'))) {
                fclose($handle);
                return true;
            }
            return false;
        }

        private function createWritableFolder($folder){
            if (file_exists($folder)) {
                return is_writable($folder);
            }
            $folderParent = dirname($folder);
            if($folderParent != '.' && $folderParent != '/' ) {
                if(!$this->createWritableFolder(dirname($folder))) {
                    return false;
                }
            }

            if ( is_writable($folderParent) ) {
                if ( mkdir($folder, 0777, true) ) {
                    return true;
                }
            }
            return false;
        }

    }