<?php

class App{
    protected $controller  ='Portofolio'; //controller default
    protected $method      ='index';      //method defaul
    protected $params      =[];           //parameter jika ada

    public function __construct()
    {
        $url = $this->parseURL();
        
        //pemanggilan controller
        if (file_exists('../admin/controllers/'.$url[0].'.php')) {
            $this->controller =$url[0];
            unset($url1[0]);
        }    
        require_once '../admin/controllers/'.$this->controller.'.php';
        $this->controller =new $this->controller;

        //pemanggilan method
        if (isset($url)) {
            if (method_exists($this->controller, $url[1])) {
                $this->method =$url[1];
                unset($url[1]);
            }
        }

        //paramenters
        if (!empty($url)) {
            $this->params =array_values($url);
        }
        //jalanlankan controller & method,serta kirim parameter jika ada 
        call_user_func_array([$this->controller,$this->method],$this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            //menghilangkan garis miring(/) di akhir url
            $url =rtrim($_GET['url'],'/');

            //menghilangkan karakter aneh atau karakter yang mengmungkinkan kita di hack
            $url =filter_var($url, FILTER_SANITIZE_URL);

            //menghilangkan tanda garis miring (/) dan mengambil strinhg-nya.
            $url =explode('/', $url);
            return $url;
     }
   }
}          