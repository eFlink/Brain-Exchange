<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;


class User_model extends Model
{    
    public function login($username, $password)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('username', $username);
        $query = $builder->get();
        $user = $query->getRowArray();
        if ($user && password_verify($password, $user['password'])) {
            // The passwords match
            return $user;
        } else {
            // The passwords do not match
            return false;
        }
    }

    public function register_user($data) 
    {
        $db = \Config\Database::connect();
        return $this->db->table('users')->insert($data);
    }

    public function add_course_to_user($user_id, $course_id) 
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user_courses');

        $data = [
            'user_id' => $user_id,
            'course_id' => $course_id
        ];

        $builder->insert($data);
    }

    public function get_total_likes($userId)
    {
        $builder = $this->db->table('posts');
        $builder->select('COUNT(favourites.post_id) as total_likes');
        $builder->join('favourites', 'favourites.post_id = posts.post_id', 'left');
        $builder->where('posts.user_id', $userId);
        $builder->groupBy('posts.user_id');

        $query = $builder->get();
        $result = $query->getRow();

        return isset($result->total_likes) ? $result->total_likes : 0;
    }

    public function get_total_posts($userId)
    {
        $builder = $this->db->table('posts');
        $builder->select('COUNT(post_id) as total_posts');
        $builder->where('user_id', $userId);

        $query = $builder->get();
        $result = $query->getRow();

        return isset($result->total_posts) ? $result->total_posts : 0;
    }
}
