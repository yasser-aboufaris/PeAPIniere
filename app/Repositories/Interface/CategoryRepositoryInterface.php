<?php 
interface categoryRepositoryInterface{
    public function Create(array $data);
    public function getAll();
    public function delete($id);
    public function GetByPost($postId);
}