<?php

require_once './Models/Database.php';

class CommentModel extends Model
{
    public function add($params)
    {
        $query = 'insert into comments (post_id, author_id, content) values(?, ?, ?)';
        $this->execStatement($query, $params);
        return $this->execStatement('select last_insert_id() as id')->get_result()->fetch_assoc()['id'];
    }

    public function update($params)
    {
        $query = 'update comments set  content = ? where id = ?';
        $this->execStatement($query, $params);
    }

    public function delete($params)
    {
        $query = 'delete from comments where id = ?';
        $this->execStatement($query, $params);
    }

    public function fetch_all()
    {
        $query = 'select * from comments';
        $stmnt = $this->execStatement($query);
        $result = $stmnt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function fetch_by_id($id)
    {
        $query = 'select comments.id, comments.content, users.username, comments.created_at from comments join users on comments.author_id = users.id where comments.id = ?';
        $stmnt = $this->execStatement($query, [$id]);
        return $stmnt->get_result()->fetch_assoc();
    }

    public function fetch_by_user($author_id)
    {
        $query = 'select comments.id, comments.content, users.username, comments.created_at from comments join users on comments.author_id = users.id where comments.author_id = ?';
        $stmnt = $this->execStatement($query, [$author_id]);
        return $stmnt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function fetch_by_post($post_id)
    {
        $query = 'select comments.id, comments.content, users.username, comments.created_at from comments join users on comments.author_id = users.id where comments.post_id = ? order by id desc';
        $params = [$post_id];
        $stmnt = $this->execStatement($query, $params);
        return $stmnt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
