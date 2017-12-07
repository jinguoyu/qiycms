<?php
namespace app\admin\controller;
use think\Db;
class Site extends Common
{
	public function index()
	{
		
		$data =Db::name('site')->where('id','1')->find();
		$this->assign('data',$data);
		return $this->fetch();
	}

	//基本信息的保存
	public function save()
	{
		$data = $_POST;		
		$file = request()->file('slogo');
		//有上传logo时
		if(!preg_match("/^1[34578]\d{9}$/",$data['telephone'])){
	
			$this->error("手机号码输入错误，请填入正确的手机号码");
		}
		if($file)
		{
			$riqi = date("Ymd",time());
			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
			$img =(ROOT_PATH.'public'.DS.'uploads'.DS.'image'.DS.$riqi.DS.$info->getFilename());
			$data['slogo'] = $img;

			$info = Db::name('site')->where('id',1)->update($data);
			if(empty($info)){
				$this->error('修改失败，请重试');
			}else{
				$this->success('修改成功');
			}
		//没有上传logo时	
		}else{
			$data=$_POST;
			unset($data['slogo']);
			$info = Db::name('site')->where('id',1)->update($data);
			if(empty($info)){
				$this->error('修改失败，请重试');
			}else{
				$this->success('修改成功');
			}

		}

	}

	//网站设置
	public function webset(){
		$data =$_POST;

		//如果$data为空则是刚打开，查询数据库，显示值
		if(empty($data)){
			$data = Db::name('webset')->where('id',1)->find();

			$this->assign('data',$data);
			return $this->fetch();			
		}else{

			$num = Db::name('webset')->where('id',1)->update($data);
			if($num=1){
				$this->success("设置成功");
			}else{
				$this->error("设置失败");
			}
		}



	} 
}