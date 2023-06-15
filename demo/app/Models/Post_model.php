<?php

namespace App\Models;

use CodeIgniter\Model;

class Post_model extends Model
{

    public function get_posts_by_course($courseId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('posts');
        $builder->select('posts.*, users.username, courses.course_name, COUNT(favourites.favourite_id) as favourite_count');
        $builder->join('users', 'users.user_id = posts.user_id');
        $builder->join('courses', 'posts.course_id = courses.course_id');
        $builder->join('favourites', 'favourites.post_id = posts.post_id', 'left'); 
        $builder->where('posts.course_id', $courseId);
        $builder->groupBy('posts.post_id'); // Group by the post ID

        $query = $builder->get();

        return $query->getResultArray();
    }


    public function create_post($userId, $courseId, $title, $description, $imagePaths)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('posts');

        $data = [
            'user_id' => $userId,
            'course_id' => $courseId,
            'title' => $title,
            'description' => $description,
            'image_path' => json_encode($imagePaths), // Encode the image paths array as a JSON string

        ];

        $builder->insert($data);

        return $db->insertID();
    }

    public function get_post_by_id($postId, $userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('posts');
        $builder->select('posts.*, users.username, courses.course_name, COUNT(favourites.favourite_id) as favourite_count, 
                        SUM(CASE WHEN favourites.user_id = '.$userId.' THEN 1 ELSE 0 END) as is_favourited');
        $builder->join('users', 'users.user_id = posts.user_id');
        $builder->join('courses', 'posts.course_id = courses.course_id');
        $builder->join('favourites', 'favourites.post_id = posts.post_id', 'left'); 
        $builder->where('posts.post_id', $postId);
        $builder->groupBy('posts.post_id'); // Group by the post ID
        $query = $builder->get();
        return $query->getRowArray();
    }


    public function get_comments_by_post_id($post_id)
    {
        $builder = $this->db->table('comments');
        $builder->select('*');
        $builder->join('users', 'comments.user_id = users.user_id');
        $builder->where('post_id', $post_id);
        $builder->orderBy('comments.created_at', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function add_comment($data)
    {
        $builder = $this->db->table('comments');
        $builder->insert($data);
    }

    public function search_posts_by_query($query)
    {
        // Get the user's courses
        $courseModel = new \App\Models\Course_model();
        $userId = session()->get('user_id');
        $courses = $courseModel->get_courses_by_user($userId);

        // Extract course IDs
        $courseIds = array_column($courses, 'course_id');

        // Search posts based on course IDs
        $db = \Config\Database::connect();
        $builder = $db->table('posts');
        $builder->select('posts.*, users.username, courses.course_name, COUNT(favourites.favourite_id) as favourite_count');
        $builder->join('users', 'users.user_id = posts.user_id');
        $builder->join('courses', 'posts.course_id = courses.course_id');
        $builder->join('favourites', 'favourites.post_id = posts.post_id', 'left');
        $builder->whereIn('posts.course_id', $courseIds);
        $builder->like('title', $query);
        $builder->groupBy('posts.post_id, users.username, courses.course_name'); 
        $query = $builder->get();


        return $query->getResultArray();
    }

    public function get_bookmarked_posts($userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('favourites');
        $builder->select('posts.*, users.username');
        $builder->join('posts', 'posts.post_id = favourites.post_id');
        $builder->join('users', 'users.user_id = posts.user_id');
        $builder->where('favourites.user_id', $userId);
        $query = $builder->get();

        return $query->getResultArray();
    }

}
