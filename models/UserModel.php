<?php


require_once __DIR__ . '/../config/database.php';

class UserModel
{
    private $conn;
    private $table = 'users';

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    /**
     * Used for login: given an IC number, join users -> students on
     * student_id to fetch the account + profile data in one query.
     */
    public function findByStudentIc($ic)
    {
        $sql = "SELECT u.id AS user_id, u.password, u.student_id,
                       s.name, s.ic, s.program, s.marks
                FROM {$this->table} u
                INNER JOIN students s ON s.id = u.student_id
                WHERE s.ic = :ic
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ic', $ic, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    /** Find a user account by its own primary key */
    public function findById($userId)
    {
        $sql  = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /** Find a user account by the student it belongs to */
    public function findByStudentId($studentId)
    {
        $sql  = "SELECT * FROM {$this->table} WHERE student_id = :sid LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':sid', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * CREATE - provisions a login account for a newly created student.
     * Called right after StudentModel::create() so every student row
     * always has exactly one matching users row.
     */
    public function createForStudent($studentId, $plainPassword)
    {
        $hashed = password_hash($plainPassword, PASSWORD_DEFAULT);
        $sql    = "INSERT INTO {$this->table} (student_id, password) VALUES (:sid, :password)";
        $stmt   = $this->conn->prepare($sql);
        $stmt->bindParam(':sid', $studentId, PDO::PARAM_INT);
        $stmt->bindParam(':password', $hashed, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /** Verify a plain-text password against the stored hash (old-password check) */
    public function verifyPassword($userId, $plainPassword)
    {
        $user = $this->findById($userId);
        if (!$user) {
            return false;
        }
        return password_verify($plainPassword, $user['password']);
    }

    /** Update only the password column, always storing a fresh hash */
    public function updatePassword($userId, $newPlainPassword)
    {
        $hashed = password_hash($newPlainPassword, PASSWORD_DEFAULT);
        $sql    = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        $stmt   = $this->conn->prepare($sql);
        $stmt->bindParam(':password', $hashed, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
