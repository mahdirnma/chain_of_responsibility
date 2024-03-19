<?php
interface HandlerInterface{
    public function setNext(HandlerInterface $next);

    public function handle($request=null);

    public function next($request=null);
}
abstract class abstractHandler implements HandlerInterface{
    protected $next;
    public function setNext(HandlerInterface $next){
        $this->next=$next;
    }
    public function next($request = null){
        if ($this->next){
            return $this->next->handle($request);
        }
    }
}
class lengthNumberValidationHandler extends abstractHandler{
    public function handle($request = null){
        if (strlen($request["mobile"])==11){
            var_dump("validation:check length");
            return $this->next($request);
        }
    }
}
class startNumberValidationHandler extends abstractHandler{
    public function handle($request = null){
        $number=$request["mobile"];
        if ($number[0]==0 && $number[1]==9){
            var_dump("validation:check start Number");
            return $this->next($request);
        }
    }
}
class lengthNameValidationHandler extends abstractHandler{
    public function handle($request = null){
        $name=$request["name"];
        if (strlen($name)>2){
            var_dump("validation:check length name");
            return $this->next($request);
        }
    }

}
$request=[
    "mobile"=>"09184977969",
    "name"=>"mahdi"
];
$lengthNumber=new lengthNumberValidationHandler();
$startNumber=new startNumberValidationHandler();
$lengthName=new lengthNameValidationHandler();

$lengthNumber->setNext($startNumber);
$startNumber->setNext($lengthName);

$lengthNumber->handle($request);