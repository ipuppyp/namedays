<?php


require_once __DIR__ . '/../vendor/autoload.php'; 

class FacebookService {
       
    private $facebookApi;
    
    function __construct($appId, $appSecret, $accessToken) {
        $this->facebookApi = new \Facebook\Facebook([
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v12.0',
            'default_access_token' => $accessToken
        ]);
        echo "Facebook service created, appId: $appId \n";
    }


    function publishPhoto($pageId, $photoFolder, $photo, $caption) {
        echo "Publishing on Facebook...\n";
        echo "page: $pageId\n";
        echo "photo:  $photo\n";
        echo "caption: $caption\n";
        
        $photoPath = $photoFolder. "/" . $photo;
        if (file_exists($photoPath)) {
            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $this->facebookApi->post(
                    '/' . $pageId. '/photos',
                    array (
                        'source' => $this->facebookApi->fileToUpload($photoPath),
                        'caption' =>  $caption
                    ));
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                return 'Graph returned an error: ' . $e->getMessage() . "\n";
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                return 'Facebook SDK returned an error: ' . $e->getMessage() . "\n";
            }
            $postId = $response->getGraphNode()["post_id"];
            
            return "Succesfully posted \"$photo\" with caption \"$caption\" to page https://www.facebook.com/$pageId, ".  
                    "post: https://www.facebook.com/$postId\n";
        }
        else {
            return "Can't post on Facebook, photo does not extist: $photo\n";
        }
        
    }



}
?>