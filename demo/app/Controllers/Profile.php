<?php 

namespace App\Controllers;

class Profile extends BaseController
{

    public function edit()
    {
        $courseModel = model('App\Models\Course_model');
        $userModel = new \App\Models\User_model();
        $courses = $courseModel->get_courses_by_user(session()->get('user_id'));
        $available_courses = $courseModel->get_available_courses(session()->get('user_id'));
        $total_likes = $userModel->get_total_likes(session()->get('user_id'));
        $total_posts = $userModel->get_total_posts(session()->get('user_id'));
        return view('edit_profile', ['available_courses' => $available_courses, 'courses' => $courses, 'total_likes' => $total_likes, 'total_posts' => $total_posts]);
    }

    public function update()
    {
        $userModel = new \App\Models\User_model();
        $courseModel = model('App\Models\Course_model');
        $user_id = session()->get('user_id');
        $course_id = $this->request->getPost('course_id');


        // Add courses
        if (!empty($course_id)) {
            $userModel->add_course_to_user($user_id, $course_id);
        }

        // Redirect back to the edit profile page with a success message
        return redirect()->to(base_url('profile/edit'))->with('success', 'Profile updated successfully!');
    }

}