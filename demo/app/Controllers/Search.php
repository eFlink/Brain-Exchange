<?php

namespace App\Controllers;

use App\Models\Post_model;

class Search extends BaseController
{

    public function index()
    {
        $query = $this->request->getVar('query') ?? '';
        $userId = session()->get('user_id');

        // Get the posts from the query given
        $postModel = new \App\Models\Post_model();
        $posts = $postModel->search_posts_by_query($query);

        // Get the courses for the sidebar
        $courseModel = new \App\Models\Course_model();
        $courses = $courseModel->get_courses_by_user($userId);

        return view('posts', ['posts' => $posts, 'courses' => $courses]);
    }

    public function suggestions()
    {
        // Sends ajax for the dropdown searches
        $query = $this->request->getVar('query');

        $postModel = new \App\Models\Post_model();
        $posts = $postModel->search_posts_by_query($query);

        return $this->response->setJSON($posts);
    }

}
