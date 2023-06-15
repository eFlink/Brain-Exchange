<?php

namespace App\Models;

use CodeIgniter\Model;

class Favourite_model extends Model
{

    public function addFavourite($postId, $userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('favourites');
        $data = [
            'post_id' => $postId,
            'user_id' => $userId
        ];
        $builder->insert($data);
        return $db->insertID();
    }

    public function removeFavourite($postId, $userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('favourites');

        if ($builder->where('post_id', $postId)->where('user_id', $userId)->countAllResults() > 0) {
            $builder->where('post_id', $postId)->where('user_id', $userId)->delete(); // Add where() clauses again before delete()
            return true;
        }

        return false;
    }

    public function isFavourited($postId, $userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('favourites');
        return $builder->where('post_id', $postId)->where('user_id', $userId)->countAllResults() > 0;
    }

    public function countFavourites($postId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('favourites');
        return $builder->where('post_id', $postId)->countAllResults();
    }
}