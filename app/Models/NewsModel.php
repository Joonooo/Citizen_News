<?php namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $allowedFields = ['title', 'link', 'category', 'description', 'pubDate'];

    public function getNews($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->asArray()
                    ->where(['id' => $id])
                    ->first();
    }
}
