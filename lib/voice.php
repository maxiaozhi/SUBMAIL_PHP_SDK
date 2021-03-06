<?PHP
    class voice{
        
        protected $base_url='http://api.mysubmail.com/';

        protected $voice_configs;
        
        protected $signType='normal';
        
        function __construct($voice_configs){
            $this->voice_configs=$voice_configs;
            if(!empty($voice_configs['server'])){
                $this->base_url=$voice_configs['server'];
            }
        }
        
        protected function createSignature($request){
            $r="";
            switch($this->signType){
                case 'normal':
                    $r=$this->voice_configs['appkey'];
                    break;
                case 'md5':
                    $r=$this->buildSignature($this->argSort($request));
                    break;
                case 'sha1':
                    $r=$this->buildSignature($this->argSort($request));
                    break;
            }
            return $r;
        }
        
        protected function buildSignature($request){
            $arg="";
            $app=$this->voice_configs['appid'];
            $appkey=$this->voice_configs['appkey'];
            while (list ($key, $val) = each ($request)) {
                $arg.=$key."=".$val."&";
            }
            $arg = substr($arg,0,count($arg)-2);
            if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
            
            if($this->signType=='sha1'){
                $r=sha1($app.$appkey.$arg.$app.$appkey);
            }else{
                $r=md5($app.$appkey.$arg.$app.$appkey);
            }
            
            return $r;
        }
        
        protected function argSort($request) {
            ksort($request);
            reset($request);
            return $request;
        }
        
        protected function getTimestamp(){
            $api=$this->base_url.'service/timestamp.json';
            $ch = curl_init($api) ;
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
            $output = curl_exec($ch) ;
            $timestamp=json_decode($output,true);
            
            return $timestamp['timestamp'];
        }
        
        protected function APIHttpRequestCURL($api,$post_data,$method='post'){
            if($method!='get'){
                $ch = curl_init();
                curl_setopt_array($ch, array(
                   CURLOPT_URL => $api,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_POSTFIELDS => http_build_query($post_data),
                   CURLOPT_CUSTOMREQUEST => strtoupper($method),
                   CURLOPT_HTTPHEADER => array("Content-Type: application/x-www-form-urlencoded")
                ));
            }else{
                $url=$api.'?'.http_build_query($post_data);
                $ch = curl_init($url) ;
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1) ;
            }
            $output = curl_exec($ch);
            curl_close($ch);
            $output = trim($output, "\xEF\xBB\xBF");
            return json_decode($output,true);
        }
        
        public function verify($request){
            $api=$this->base_url.'voice/verify.json';
            $request['appid']=$this->voice_configs['appid'];
            $request['timestamp']=$this->getTimestamp();
            if(empty($this->voice_configs['sign_type'])
               && $this->voice_configs['sign_type']==""
               && $this->voice_configs['sign_type']!="normal"
               && $this->voice_configs['sign_type']!="md5"
               && $this->voice_configs['sign_type']!="sha1"){
                $this->signType='normal';
            }else{
                $this->signType=$this->voice_configs['sign_type'];
                $request['sign_type']=$this->voice_configs['sign_type'];
            }
            $request['signature']=$this->createSignature($request);
            $send=$this->APIHttpRequestCURL($api,$request);
            return $send;
        }
        public function xsend($request){
            $api=$this->base_url.'voice/xsend.json';
            $request['appid']=$this->voice_configs['appid'];
            $request['timestamp']=$this->getTimestamp();
            if(empty($this->voice_configs['sign_type'])
               && $this->voice_configs['sign_type']==""
               && $this->voice_configs['sign_type']!="normal"
               && $this->voice_configs['sign_type']!="md5"
               && $this->voice_configs['sign_type']!="sha1"){
                $this->signType='normal';
            }else{
                $this->signType=$this->voice_configs['sign_type'];
                $request['sign_type']=$this->voice_configs['sign_type'];
            }
            $request['signature']=$this->createSignature($request);
            $send=$this->APIHttpRequestCURL($api,$request);
            return $send;
        }
        public function send($request){
            $api=$this->base_url.'voice/send.json';
            $request['appid']=$this->voice_configs['appid'];
            $request['timestamp']=$this->getTimestamp();
            if(empty($this->voice_configs['sign_type'])
               && $this->voice_configs['sign_type']==""
               && $this->voice_configs['sign_type']!="normal"
               && $this->voice_configs['sign_type']!="md5"
               && $this->voice_configs['sign_type']!="sha1"){
                $this->signType='normal';
            }else{
                $this->signType=$this->voice_configs['sign_type'];
                $request['sign_type']=$this->voice_configs['sign_type'];
            }
            $request['signature']=$this->createSignature($request);
            $send=$this->APIHttpRequestCURL($api,$request);
            return $send;
        }
        public function multixsend($request){
            $api=$this->base_url.'voice/multixsend.json';
            $request['appid']=$this->voice_configs['appid'];
            $request['timestamp']=$this->getTimestamp();
            if(empty($this->voice_configs['sign_type'])
               && $this->voice_configs['sign_type']==""
               && $this->voice_configs['sign_type']!="normal"
               && $this->voice_configs['sign_type']!="md5"
               && $this->voice_configs['sign_type']!="sha1"){
                $this->signType='normal';
            }else{
                $this->signType=$this->voice_configs['sign_type'];
                $request['sign_type']=$this->voice_configs['sign_type'];
            }
            $request['signature']=$this->createSignature($request);
            $send=$this->APIHttpRequestCURL($api,$request);
            return $send;
        }
    }
