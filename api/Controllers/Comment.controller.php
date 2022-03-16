<?php

include_once './Models/Comment.model.php';
class Comment
{
    private $id;
    private $post_id;
    private $author_id;
    private $content;
    private $created_at;
    private $model;

    public function __construct($author_id, $post_id, $content, $created_at = null, $id = null)
    {
        $this->id = $id;
        $this->author_id = $author_id;
        $this->post_id = $post_id;
        $this->content = $content;
        $this->created_at = $created_at;
        $this->model = new CommentModel();
    }

    public function add()
    {
        try {
            $params = array($this->post_id, $this->author_id, $this->content);
            $this->id = $this->model->add($params);
            echo json_encode(['added'=>true]);
        } catch (Throwable) {
            echo json_encode(['added'=>false]);
        }
    }

    public function update($params)
    {
        $this->content = isset($params['content']) ? $params['content'] : $this->content;
        $params = [$this->content, $this->id];
        $this->model->update($params);
    }

    public function delete()
    {
        $params = array($this->id);
        $this->model->delete($params);
    }

    public static function fetch_all()
    {
        $postModel = new CommentModel();
        $result = $postModel->fetch_all();
        return $result;
    }

    public static function fetch_by_id($id)
    {
        $commentModel = new CommentModel();
        $comment = $commentModel->fetch_by_id($id);
        return new Comment(null, null, $comment['content'], $comment['created_at'], $id);
    }

    public static function fetch_by_post($post_id)
    {
        $commentModel = new CommentModel();
        $comments = $commentModel->fetch_by_post($post_id);
        return $comments;
    }
}
