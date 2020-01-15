<?php
namespace backend\module\document\controllers;

// require_once __DIR__.'/../../../vendor/autoload.php';
use Yii;
// use PhpOffice\PhpWord\IOFactory;
// use PhpOffice\PhpWord\Settings;
// use PhpOffice\PhpWord\PhpWord;
// use PhpOffice\PhpWord\Style;
// use PhpOffice\PhpWord\TemplateProcessor;


use yii\web\Controller;
use yii\web\Response;
use yii\web\Request;
use yii\data\Pagination;
use yii\db\Query;
use common\models\OaFlowInfo;
use common\models\OaList10;
use common\models\OaList;
use common\models\OaList1;
use common\models\OaTest;
use common\models\Upload;
use yii\web\UploadedFile;
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-type,Accept");

// <!-- 文件相关操作 -->
class FileController extends Controller
{
	public function actionIndex()
	{
        $request = \Yii::$app->request;
        $s = $request->post('doc');
        $dir = \Yii::$app->basePath;//物理路径E:\Net\xampp\htdocs\OA\advanced\backend
        $dirr = \Yii::$app->request->hostInfo;//域名地址http://127.0.0.1
        $d = dirname(Yii::$app->BasePath);//项目路径E:\Net\xampp\htdocs\OA\advanced
        $url = \Yii::$app->request->url;// /OA/advanced/backend/web/index.php/document/file/index
		// $mmm=dirname(__DIR__).'/../..';
        $pwd = getcwd();
        $time = getdate();
        return array("data"=>[$s,$dir,$dirr,$d,$url,$pwd,$time],"msg"=>"文件相关操作");
	}
    public function actionUploadfile()
    {
        $menu = str_replace('\\','/',dirname(Yii::$app->BasePath));
        $upload_path =$menu.'/'.@backend."/Uploads/";
        $filename=$_FILES["file"]["name"];
        $fileArr = explode('.',$filename);
        // $tempName=date("YmdHis").rand(1,100).".".$fileArr[1];
        $tempName=date("YmdHis").".".$fileArr[1];
        move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path.$tempName);
        // $file = array('filename' => 'filename','dir'=>'filedir' );
        $file = array('filename' => 'filename','dir'=>'filedir' );
        $file['filename'] = $filename;
        $file['dir'] = $upload_path.$tempName;
        // return array("data"=>[$menu,$upload_path,$filename,$fileArr,$tempName,$file],"msg"=>"上传成功");
        return array("data"=>[$tempName,$file['filename'],$file['dir']],"msg"=>"上传成功");
    }
    public function actionDownloadlist()
    {
        //下载申请表2
        $request = \Yii::$app->request;
        // $procname = $request->post('procname');
        $userid = $request->post('userid');
        $procid = $request->post('procid');
        $query1 = (new Query())
                    ->select('*')
                    ->from('oa_list10')
                    ->andWhere(['userid' => $userid])
                    ->andWhere(['procid' => $procid])
                    ->andWhere(['isvaild' => 1])
                    ->one();
        $filedir = $query1['text'];
        $fileArr = explode('Uploads/',$filedir);
        $filedir1 = $fileArr[1];
        $filename = $query1['content'];

        if(!file_exists($filedir))
        {
            return array("data" => "11","msg" => "找不到该文件");
        }
        else{
            return array("data"=>["/Uploads/{$filedir1}",$filename],"msg" =>"下载文件");
            // 文件不宜用流的形式传输
            // header("Content-type:application/octet-stream");
            // header("Accept-Ranges:bytes");
            // header("Accept-Length:".filesize($filedir));
            // header("Content-Disposition:attchment;filename=".$filename);
            // $file = fopen($filedir, "r");
            // $str = fread($file,filesize($filedir));
            // $str = str_replace("\r\n", "<br />", $str);
            // $str =mb_convert_encoding($str, 'utf-8','utf-8,GBK,GB2312,BIG5');
            // fclose($file);
            // $str = file_get_contents($filedir);
            // $file = fopen($filedir, "rb");
            // header("Content-type:application/octet-stream");
            // header("Accept-Ranges:bytes");
            // header("Accept-Length:".filesize($filedir));
            // header("Content-Disposition:attchment;filename=".$filename);
            // readfile($filedir);
            // $filesize = filesize($filedir);
            // $fileopen = fopen($filedir, "r");
            // $file = fread($fileopen, $filesize);
            // fread($file, filesize($filedir));
            // fclose($file);
            // return array("data" => [$filename,$filedir,$str],"msg" => "查看成功");
        }
        // return array("data" => [$filename,$filedir],"msg" => "查看成功");
    }
    //没有用到
    public function actionUpload()
    {
        $request = \Yii::$app->request;
        $s = $request->post('fileList');
        return array("data"=>$s,"msg"=>"111");
        $filename = $_FILES["upfile"]["name"];
        $uploadDir = getcwd()."\\files\\";
        if(!is_dir($uploadDir))
        {
            mkdir($uploadDir);
        }
        $dir = $uploadDir."/".$filename;
        $m=move_uploaded_file($_FILES["upfile"]["tmp_name"], iconv("utf-8", "GB2312", $dir."/".$_FILES["upfile"]["name"]));
        return array("data"=>[$filename,$m],"msg"=>"11");
    }
    //没有用到
    public function actionFileupload()
    {

        $request = \Yii::$app->request;
        $s = $request->post('data');
        return array("data"=>$s,"msg"=>"111");
        $uploadDir = getcwd()."\\files\\";
        if(!is_dir($uploadDir))
        {
            mkdir($uploadDir);
        }
        $filename = $uploadDir;
        $m=move_uploaded_file($s, $filename);
        return array("data"=>[$s,$uploadDir,$filename,$m],"msg"=>"11");
    }
    // public function actionUpload()
    // {
    //     // $model = new Upload();
    //     if(\Yii::$app->request->isPost)
    //     {
    //         // $mfile = \Yii::$app->request->post('doc');
    //         $mfile = UploadedFile::getInstanceByName('file');
    //         $dir = 'uploads/';
    //         if(!is_dir($dir))
    //         {
    //             mkdir($dir);
    //         }

    // }
}
    // public $enableCsrfValidation =false;
    // public function actionUpload()
    // {
    //     $request = \Yii::$app->request;
    //     $_FILES = $request->post("file");
    //     move_uploaded_file($_FILES["file"],["tmp_name"],"uploads/".$_FILES["file"]["name"]);
    //     echo $_FILES["file"]["name"];
    //     $id = rand(,time());
    //     $url = 'http://phpitm.grouptong.top:8081/Upload/'.$_FILES["file"]["name"];
    //     $connent = \Yii::$app->db->createCommand()->insert('oa_test',array(
    //         'content'=>$url)
    //     )->execute();
    //     return array("data"=>$connent,"msg"=>"文件上传");
    // }
	// public function actionDemo()
	// {
	// 	$PHPWord = new PHPWord();
	// 	$document = $PHPWord->loadTemplate('./word/Examples/Template.docx');
	// 	$document->setValue('Value1',iconv('utf-8', 'GB2312//IGNORE','1'));
	// 	$document->setValue('Value2',iconv('utf-8', 'GB2312//IGNORE','2'));
	// 	$filename = './word/Examples/m-i-'.time().'.docx';
	// 	$document->save($filename);
	// }
	// public function actionDownloaddemo()
	// {
	// 	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	// 	$section = $phpWord->addSection();
	// 	$section->addText("Learn from yesterday, live for today, hope for tomorrow.");
 //    	$section->addText(
 //    		"Great achievement is usually born of great sacrifice.",array('name' => 'Tahoma', 'size' => 10));
 //    	$fontStyleName = 'oneUserDefinedStyle';
 //    	$phpWord->addFontStyle($fontStyleName,array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true));
 //    	$section->addText("The greatest accomplishment is not in never falling.",$fontStyleName);
 //    	$fontStyle = new \PhpOffice\PhpWord\Style\Font();
 //    	$fontStyle->setBold(true);
 //    	$fontStyle->setName('Tahoma');
 //    	$fontStyle->setSize(13);
 //    	$myTextElement = $section->addText('"Believe you can and you halfway there." (Theodor Roosevelt)');
 //    	$myTextElement->setFontStyle($fontStyle);
 //    	Header("Content-type:application/octet-stream");
 //    	Header("Accept-Ranges:bytes");
 //    	Header("Content-Disposition:attchment; filename=".'测试文件.docx')
 //    	ob_clean();//关键
 //    	flush();//关键
 //    	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 //    	$objWriter->save("php://output");
 //    	exit();
	// }
	// public function actionDownloadtoword()
	// {
	// 	//下载为word
	// 	$request = \Yii::$app->request;
 //        $procname = $request->post('procname');
 //        $userid = $request->post('userid');
 //        $procid = $request->post('procid');
 //        $list = (new Query())->select('listid')->from('oa_list')->andWhere(['listname' => $procname])->one();
 //        if($list['listid'] == 3)
 //        {
 //            $query1 = (new Query())
 //                    ->select('*')
 //                    ->from('oa_list10')
 //                    ->andWhere(['userid' => $userid])
 //                    ->andWhere(['procid' => $procid])
 //                    ->andWhere(['isvaild' => 1])
 //                    ->one();
 //            return array("data" => [$query1],"msg" => "查看成功");
 //        }

	// }

