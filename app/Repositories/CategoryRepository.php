<?php 

namespace App\Repositories;
use App\Models\Category;
use App\Repositories\Interface\CategoryRepositoryInterface;
class categoryRepository implements CategoryRepositoryInterface {
    public function create(array $array){
        Category::create($array);
    }
    
    public function getAll(){
        $categories = Category::all();
        return $categories;
    }
    
    public function delete($id){
        return Category::destroy($id);
    
    }
    
    
    
}