<?php
class FacebookController extends AppController{
    public $uses = array("FbPost", "Segment");
    //public $layout = "default";

    public function index(){
        $this->layout = "loginpage";
    }

    public function login() {
        $user = $this->facebook->getUser();
    	// Facebookへ接続
    	if($user) {
    		$this->redirect(array('action' => 'myPage'));
    	} else {
            $this->authFacebook();
    	}
    }

    public function myPage(){
        $this->layout = "mypage";

        $user = $this->facebook->getUser();

        if(!$user) {
        	$this->redirect(array('action' => 'index'));
        }

        try{
            $me = $this->facebook->api('/me');
            $friends_data = $this->facebook->api('/me/friends?fields=id,name,birthday');
        }
        catch(FacebookApiException $e){
            error_log($e);
        }

        $this->set(compact('user'));
        $this->set(compact('me'));
        $this->set(compact('friends_data'));

        //データベースから自分に対する投稿データを取ってくる
        $posts = $this->FbPost->find("all", array("conditions" => array("FbPost.friend_id" => $me["id"])));
        //データベースから自分のセグメント情報を取ってくる
        $segmentList = $this->Segment->find("first", array("conditions" => array("Segment.user_id" => $me["id"])));

        $this->set("posts", $posts);
        $this->set("segmentList", $segmentList);
    }

    public function friendPage($id = null, $name = null, $birthday = null){
        $this->layout = "friendpage";

        if(isset($this->request->query["friendID"])){
            $friendID = $this->request->query["friendID"];
            $friendName = $this->request->query["friendName"];
            $friendBirthday = $this->request->query["friendBirthday"];

            $friendData = $this->FbPost->find("all", array("conditions" => array("FbPost.friend_id" => $friendID)));

            //データベースから自分のセグメント情報を取ってくる
            $segmentList = $this->Segment->find("first", array("conditions" => array("Segment.user_id" => $friendID)));

            if(empty($friendData)){
                $this->set("friendData", "あなたへの投稿はありません");
            }
        }

        //idを渡されてたらそこから取得
        if($id != null){
            $friendID = $id;
            $friendName = $name;
            $friendBirthday = date('Y/m/d', strtotime($birthday));

            $friendData = $this->FbPost->find("all", array("conditions" => array("FbPost.friend_id" => $id)));
             //データベースから自分のセグメント情報を取ってくる
            $segmentList = $this->Segment->find("first", array("conditions" => array("Segment.user_id" => $friendID)));

        }

        $this->set("friend_id", $friendID);
        $this->set("friendName", $friendName);
        $this->set("friendBirthday", $friendBirthday);
        $this->set("friendData", $friendData);
        $this->set("segmentList", $segmentList);


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
    }

    public function logout(){
        $this->facebook->destroySession();
        $this->redirect(array("action" => "index"));
    }
}
