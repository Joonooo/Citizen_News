<?php
namespace App\Models;

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

    public function getDistinctCategories()
    {
        return $this->select('category')->distinct()->findAll();
    }

    public function getNewsByCategory($category = null)
    {
        if ($category) {
            return $this->where('category', $category)->findAll();
        }

        return $this->findAll();
    }
}
