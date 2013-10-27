<?php

class SegmentsController extends AppController{
	public $uses = array("Segment");
	public $layout = "mysegment";

	public function index(){
        // Facebookへ接続
        $this->connectFb();
        $fb = $this->facebook->getUser();

        try{
            $me = $this->facebook->api('/me');
            $friends_data = $this->facebook->api('/me/friends?fields=id,name,birthday');
        }
        catch(FacebookApiException $e){
            error_log($e);
        }

        $this->set(compact('fb'));
        $this->set(compact('me'));
        $this->set(compact('friends_data'));

        $segmentList = $this->Segment->find("first", array("conditions" => array("Segment.user_id" => $me["id"])));

        $this->set("segmentList", $segmentList);
	}

	public function add(){
		if ($this->request->is('post')){

			for($i = 0; $i < count($this->request->data["segment-body"]); $i++){
				$data[] = $this->request->data["segment-body"][$i];

				$this->request->data["Segment"]["body"] = json_encode($data);
			}

			for($i = 0; $i < count($this->request->data["segment-date"]); $i++){
				$dateData[] = $this->request->data["segment-date"][$i]["year"];

				$this->request->data["Segment"]["date"] = json_encode($dateData);
			}

			/*
			$this->request->data['Segment']['body'] = json_encode($this->request->data['segment-body'], JSON_UNESCAPED_UNICODE);
			*/


			//2重登録の防止
			$data = $this->Segment->find("first", array("conditions" => array("Segment.user_id" => $this->request->data["Segment"]["user_id"])));

			if(!empty($data)){
				$this->Segment->id = $data["Segment"]["id"];

				if($this->Segment->save($this->request->data)){
					//$this->Session->setFlash("成功");
					$this->redirect(array("controller" => "facebook", "action" => "myPage"));
				}
				else{
					throw new NotFoundException(__('Invalid segment'));
				}
			}

			$this->Segment->create();
			if($this->Segment->save($this->request->data)){
				//$this->Session->setFlash("成功");
				$this->redirect(array("controller" => "facebook", "action" => "myPage"));
			}
			else{
				throw new NotFoundException(__('Invalid segment'));
			}
		}
	}
}