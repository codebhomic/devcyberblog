<?php
require_once '../db_connect.php';
require_once '../constants.php';
require_once '../helper.php';
class BlogArticle
{
    private $conn;
    private $table = 'blog_article';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create new article
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (title, content, author_id, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $data['title'], $data['content'], $data['author_id']);
        return $stmt->execute();
    }

    // Get all articles
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get single article by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update article
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET title = ?, content = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $data['title'], $data['content'], $id);
        return $stmt->execute();
    }

    // Delete article
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
