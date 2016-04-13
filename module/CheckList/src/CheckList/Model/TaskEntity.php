<?php
namespace CheckList\Model;

class TaskEntity{
    protected $id;
    protected $title;
    protected $completed = 0;
    protected $created;

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title){
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getCompleted(){
        return $this->completed;
    }

    /**
     * @param int $completed
     */
    public function setCompleted($completed){
        $this->completed = $completed;
    }

    /**
     * @return mixed
     */
    public function getCreated(){
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created){
        $this->created = $created;
    }


}