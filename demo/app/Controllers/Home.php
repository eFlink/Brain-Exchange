<?php 

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Files\File;

class Home extends BaseController
{
    public function index()
    {
        // Get the courses for the sidebar
        $courseModel = model('App\Models\Course_model');
        $courses = $courseModel->get_courses_by_user(session()->get('user_id'));

        return view('home', ['courses' => $courses]);
    }


    public function course_posts($courseId) {
        // Get the posts for the courses
        $postModel = new \App\Models\Post_model();
        $sortByFavorites = $this->request->getGet('sort') === 'favorites';
        
        $posts = $postModel->get_posts_by_course($courseId);

        if ($sortByFavorites) {
            usort($posts, function ($a, $b) {
                return $b['favourite_count'] - $a['favourite_count'];
            });
        }
        // Get the courses for the sidebar
        $courseModel = model('App\Models\Course_model');
        $courses = $courseModel->get_courses_by_user(session()->get('user_id'));


        return view("posts", ['posts' => $posts, 'courses' => $courses]);
    }
    
    public function create_post() 
    {
        $userId = session()->get('user_id');
        // Get the courses for the sidebar
        $courseModel = new \App\Models\Course_model();
        $courses = $courseModel->get_courses_by_user($userId);

        echo view('create_post', ['courses' => $courses]);
    }

    public function check_post() 
    {
        helper(['form', 'url']);


  // Add the new post to the database
  $imagePaths = [];

  // Check if there are any uploaded files
  if ($this->request->getFiles()) {
    $images = $this->request->getFiles()['images'];

    // Iterate over each uploaded file
    foreach ($images as $image) {
      // If an image has been given, add it to the uploads folder and set the image path
      if ($image->isValid() && !$image->hasMoved()) {
        $newName = $image->getRandomName();
        $path = ROOTPATH.'writable/uploads/';
        $image->move($path, $newName);
        $imagePaths[] = '/demo/writable/uploads/' . $newName;

        $imageModel = new \App\Models\Image_model();

        // Crop the image
        $imageModel->rotate($path, $newName);
      }
    }
  }

        // Create the post with the information given
        $postModel = new \App\Models\Post_model();
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $userId = session()->get('user_id');
        $courseId = $this->request->getPost('course_id');

        $postId = $postModel->create_post($userId, $courseId, $title, $description, $imagePaths);

        // If the post was uploaded return user to home, otherwise return user to create_post with the validation errors present.
        if ($postId) {
            return redirect()->to(base_url('home'));
        } else {
            $courseModel = new \App\Models\Course_model();
            $courses = $courseModel->get_courses_by_user($userId);
            echo view('create_post', ['courses' => $courses]);
        }
    }

    public function post_details($post_id)
    {
        // Get the post row
        $postModel = new \App\Models\Post_model();
        $userId = session()->get('user_id');
        $post = $postModel->get_post_by_id($post_id, $userId);

        if ($post) {
            // If valid, send the user to the post
            $comments = $postModel->get_comments_by_post_id($post_id);
            $courseModel = model('App\Models\Course_model');
            $courses = $courseModel->get_courses_by_user(session()->get('user_id'));
            echo view('post_details', ['post' => $post, 'comments' => $comments, 'courses' => $courses]);
        } else {
            // Redirect to home or show an error message
            return redirect()->to(base_url('home'));
        }
    }

    public function add_comment()
    {
        // Add comment to post
        $postModel = new \App\Models\Post_model();
        $post_id = $this->request->getPost('post_id');

        $data = array(
            'post_id' => $post_id,
            'user_id' => session()->get("user_id"),
            'content' => $this->request->getPost('content')
        );

        $postModel->add_comment($data);
        return redirect()->to(base_url('home/post_details/' . $post_id));
    }

    public function bookmarks()
    {
        $userId = session()->get('user_id');
        $postModel = new \App\Models\Post_model();
        $posts = $postModel->get_bookmarked_posts($userId);

        $courseModel = model('App\Models\Course_model');
        $courses = $courseModel->get_courses_by_user(session()->get('user_id'));

        return view("bookmarks", ['posts' => $posts, 'courses' => $courses]);
    }


}

