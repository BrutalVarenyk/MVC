<?php
namespace Core;

class Controller
{
    protected array $routeParams = [];

    protected string $beforeError = "Method is no allowed";


    public function __construct($routeParams)
    {
//        dd($routeParams);
        $this->routeParams = $routeParams;
    }

    public function __call(string $method, array $arguments)
    {
//        dd($this->routeParams);
        if(method_exists($this, $method)) {
            if($this->before() !== false){ // Можна сделать валидацию, то есть проверку
                call_user_func_array([$this, $method], $arguments); // ?!?!
                $this->after();
            }else{
                throw new \Exception($this->beforeError);
            }
        } else {
            throw new \Exception("Method {$method} not found in controller " . get_class($this));
        }
    }

    //В качестве валидации
    public function before(): bool
    {
//        call_user_func()
        return true;
    }

    //После action
    public function after(): void {}

}