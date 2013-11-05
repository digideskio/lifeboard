<?php

class FbPostsController extends AppController{
	public $uses = array("FbPost");

	public function add(){
        if($this->request->is("post")){
        	// Facebookへ接続
	        $this->connectFb();
	        $fb = $this->facebook->getUser();
	        $access_token = $this->facebook->getAccessToken();

	        try{
	            $me = $this->facebook->api('/me');
	        }
	        catch(FacebookApiException $e){
	            error_log($e);
	        }


            if(!empty($this->request->data)){
            	//Feed投稿用の設定
		        $attachment = array(
				    'access_token' => $access_token,
				    'message' => "@" . $this->request->data["FbPost"]["friend_name"] . "さんのことについて「LifeBoard」に書き込みました。",
				    'name' => $this->request->data["FbPost"]["user_name"],
				    'link' => "http://lifeboard.jp/facebook/index",
				    'description' => "Lifeboardは、友だちの人生を記録するWebサービスです。ボードに当時の印象や思い出を書いたり、今の人柄を書き込んだりして、友だちを皆に紹介しましょう。",
				    'picture'=> "http://akiho-develop.under.jp/description.png"
				);

            	if(!empty($this->request->data["FbPost"]["photo_pass"]["name"])){
	            	if(is_uploaded_file($this->request->data["FbPost"]["photo_pass"]["tmp_name"])){
	            		if(strlen($this->request->data["FbPost"]["photo_pass"]["name"]) == mb_strlen($this->request->data["FbPost"]["photo_pass"]["name"])){
	            			//アップロードするファイルの場所を指定
	            			$uploaddir = "img/post-photos/";
	            			$uploadfile = $uploaddir . DS . basename($this->request->data["FbPost"]["photo_pass"]["name"]);

	            			//同じ名前のファイルがすでに存在すれば、別名に変える
	            			$info = pathinfo($uploadfile);

	            			$i = 1;
	            			while(file_exists($uploadfile)){
	            				$i++;
								$file_name = basename($info["basename"], "." . $info["extension"]) . "_" . $i . "." . $info["extension"];
								$uploadfile = $info['dirname'] . DS . $file_name;
	                        	$this->log("アップロードファイル名を再作成：" . $uploadfile, LOG_DEBUG);
	                        	$this->request->data["FbPost"]["photo_pass"]["name"] = $file_name;
	            			}

	            			//画像を一時的なファイルから正式な場所へ移動
	            			if(move_uploaded_file($this->request->data["FbPost"]["photo_pass"]["tmp_name"], $uploadfile)){
	            				chmod($uploadfile, 0666);

	            				$this->FbPost->create();
	            				$this->request->data["FbPost"]["photo_pass"] = $this->params["data"]["FbPost"]["photo_pass"]["name"];

	            				if($this->FbPost->save($this->request->data, false, array("id", "user_id", "friend_id", "user_name", "body", "segment"))){

	            					$this->FbPost->id = $this->FbPost->getLastInsertID();

	            					$data = array('FbPost' => array('id' => $this->FbPost->id, 'photo_pass' => $this->request->data["FbPost"]["photo_pass"]));

	            					$fields = array("photo_pass");

	            					if($this->FbPost->save($data, false, $fields)){
	            						//自分のFBFeedに投稿
	            						$this->facebook->api('/me/feed', 'POST', $attachment);

	            						$this->redirect(array("controller" => "facebook", "action" => "friendPage", $this->request->data["FbPost"]["friend_id"], $this->request->data["FbPost"]["friend_name"], date('Y-m-d', strtotime($this->request->data["FbPost"]["friend_birthday"]))));
	            					}
	            					else{
	            						throw new NotFoundException(__('can not save photo'));
	            					}
	            				}
	            				else{
	            					throw new NotFoundException(__('can not save data'));
	            				}
	            			}
	            			else{
	            				throw new NotFoundException(__('can not move photo'));
	            			}
 	            		}
 	            		else{
 	            			//自分のFBFeedに投稿
	            			$this->facebook->api('/me/feed', 'POST', $attachment);

 	            			$this->redirect(array("controller" => "facebook", "action" => "friendPage", $this->request->data["FbPost"]["friend_id"], $this->request->data["FbPost"]["friend_name"], date('Y-m-d', strtotime($this->request->data["FbPost"]["friend_birthday"]))));
 	            		}
	            	}
	            	else{
						throw new NotFoundException(__('can not move photo'));
 	            	}
	        	}

	        	//画像が無い場合の処理
                else{
                	if($this->FbPost->save($this->request->data, false, array("id", "user_id", "friend_id", "user_name", "body", "segment"))){
                		//自分のFBFeedに投稿
	            		$this->facebook->api('/me/feed', 'POST', $attachment);

                    	$this->redirect(array("controller" => "facebook", "action" => "friendPage", $this->request->data["FbPost"]["friend_id"], $this->request->data["FbPost"]["friend_name"], date('Y-m-d', strtotime($this->request->data["FbPost"]["friend_birthday"]))));
                	}
                	else{
                		throw new NotFoundException(__('can not save'));
                    	//$this->redirect(array("controller" => "facebook", "action" => "display"));
                	}
                }
            }
            else{
            	throw new NotFoundException(__('empty body'));
                //$this->redirect(array("controller" => "facebook", "action" => "display"));
            }
        }
    }

    public function delete($postID, $friendID){
    		if($this->FbPost->delete($postID)){
    			$this->redirect(array("controller" => "facebook", "action" => "friendPage", $friendID));
    		}
    		else{
    			throw new NotFoundException(__('can not delete'));
    		}
    }
}