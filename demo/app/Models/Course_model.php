<?php

namespace App\Models;

use CodeIgniter\Model;

class Course_model extends model
{
    public function get_courses_by_user($userId) 
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user_courses');
        $builder->select('courses.*');
        $builder->join('courses', 'courses.course_id = user_courses.course_id');
        $builder->where('user_courses.user_id', $userId);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function get_available_courses($userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('courses');
        $builder->select('*');
        $builder->where('course_id NOT IN (SELECT course_id FROM user_courses WHERE user_id = '.$userId.')');
        $query = $builder->get();

        return $query->getResultArray();
    }



}