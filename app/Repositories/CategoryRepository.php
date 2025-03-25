<?php 
class categoryRepository implements categoryRepositoryInterface {
    public function create(array $array){
        Category::create($array);
    }
    
    public function getAll(){
        $categories = Category::all();
        return $categories;
    }

    public function delete($id){
        Category::destroy($id);
    }
    

} 