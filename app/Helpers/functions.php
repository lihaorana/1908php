<?php
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;


use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

  function cateinfo($info,$p_id=0,$level=1){
    static $res=[];
    foreach($info as $k=>$v) {
        if ($v['p_id']==$p_id){
            $v['level']=$level;
            $res[] = $v;
            cateinfo($info, $v['cate_id'],$v['level'] + 1);
        }
    }
    return $res;
}
   function upload($filename){
    if(request()->file($filename)->isValid()){
        $file=request()->file($filename);
        return   $file->store($filename);
    }
    exit('文件上传错误');
}

//多个文件上传
        function  MoreUploads($filename){
            //接受上传信息
            $files=request()->file($filename);
            //判断是否是数组
            if(!is_array($files)){
                return;
            }

            foreach($files as $v){
                if ($v->isValid()){
                    $file[]= $v->store($filename);
                }
            }
            $str = implode('|', $file);
            // 返回入库信息
            return $str;
        }

/**发送短信*/
 function sendSms($account,$code){

AlibabaCloud::accessKeyClient('LTAI4FdSqqFvwJFaRSsXzVrp', 'l5AWhsfxHbvFkPk4VhiwVyEBOHzYSp')
    ->regionId('LTAI4FdSqqFvwJFaRSsXzVrp')
    ->asDefaultClient();

try {
    $result = AlibabaCloud::rpc()
        ->product('Dysmsapi')
        // ->scheme('https') // https | http
        ->version('2017-05-25')
        ->action('SendSms')
        ->method('POST')
        ->host('dysmsapi.aliyuncs.com')
        ->options([
            'query' => [
                'RegionId' => "LTAI4FdSqqFvwJFaRSsXzVrp",
                'PhoneNumbers' => $account,
                'SignName' => "php代码短信",
                'TemplateCode' => "SMS_180952142",
                'TemplateParam' => "{code:$code}",
            ],
        ])
        ->request();
return     $result->toArray();
} catch (ClientException $e) {
    return $e->getErrorMessage() . PHP_EOL;
} catch (ServerException $e) {
    return $e->getErrorMessage() . PHP_EOL;
}

}


function JsonSuccess($msg=''){
    return  json_encode(['code'=>1,'msg'=>$msg]);
}
function JsonError($msg){
    return  json_encode(['code'=>2,'msg'=>$msg]);
}

 function getemail($email){
//    $email='2660919039@qq.com';
    Mail::to($email)->send(new SendEmail());
}