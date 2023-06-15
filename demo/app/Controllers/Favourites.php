<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Favourite_model;

class Favourites extends BaseController
{
    public function toggle()
    {
        // Get the variables
        $postId = $this->request->getVar('post_id');
        $userId = session()->get('user_id'); 

        $favouriteModel = new \App\Models\Favourite_model();

        // Determine whether the post has been favorited by the user; 
        // if it has, remove it from their list of favorites, and if not, add it to their favorites.
        if ($favouriteModel->isFavourited($postId, $userId)) {
            $favouriteModel->removeFavourite($postId, $userId);
        } else {
            $favouriteModel->addFavourite($postId, $userId);
        }

        // Get information regarding the post and set it as JSON response
        $favouriteCount = $favouriteModel->countFavourites($postId);
        $isFavourited = $favouriteModel->isFavourited($postId, $userId);

        return $this->response->setJSON([
            'success' => true,
            'is_favourited' => $isFavourited,
            'favourite_count' => $favouriteCount,
        ]);
    }
}
