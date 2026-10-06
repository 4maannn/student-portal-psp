<?php


require_once __DIR__ . '/../config/database.php';

class StudentModel
{
    private $conn;
    private $table = 'students';

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    /** Find a single student by IC number */
    public function findByIc($ic)
    {
        $sql  = "SELECT * FROM {$this->table} WHERE ic = :ic LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ic', $ic, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    /** Find a single student by primary key */
    public function findById($id)
    {
        $sql  = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /** READ - get every student record */
    public function getAll()
    {
        $sql  = "SELECT * FROM {$this->table} ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** CREATE - insert a new student record. Returns the new student's id. */
    public function create($name, $ic, $program, $marks)
    {
        $sql  = "INSERT INTO {$this->table} (name, ic, program, marks)
                 VALUES (:name, :ic, :program, :marks)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':ic', $ic, PDO::PARAM_STR);
        $stmt->bindParam(':program', $program, PDO::PARAM_STR);
        $stmt->bindParam(':marks', $marks);
        $stmt->execute();
        return (int) $this->conn->lastInsertId();
    }

    /** UPDATE - edit an existing student's name / ic / program / marks */
    public function update($id, $name, $ic, $program, $marks)
    {
        $sql  = "UPDATE {$this->table}
                 SET name = :name, ic = :ic, program = :program, marks = :marks
                 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':ic', $ic, PDO::PARAM_STR);
        $stmt->bindParam(':program', $program, PDO::PARAM_STR);
        $stmt->bindParam(':marks', $marks);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * DELETE - remove a student record permanently.
     * The related row in "users" is removed automatically by the
     * ON DELETE CASCADE foreign key defined in database.sql.
     */
    public function delete($id)
    {
        // Remove the student's uploaded picture from disk (if any) before the row is deleted
        $student = $this->findById($id);
        if ($student && !empty($student['profile_picture'])) {
            $path = __DIR__ . '/../uploads/profile/' . basename($student['profile_picture']);
            if (is_file($path)) {
                unlink($path);
            }
        }

        $sql  = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /** Store the (already renamed) profile picture filename for one student */
    public function updateProfilePicture($id, $filename)
    {
        $sql  = "UPDATE {$this->table} SET profile_picture = :pic WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':pic', $filename, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /** Check whether an IC number is already taken (optionally excluding one id, for edit forms) */
    public function icExists($ic, $excludeId = null)
    {
        if ($excludeId) {
            $sql  = "SELECT id FROM {$this->table} WHERE ic = :ic AND id != :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
        } else {
            $sql  = "SELECT id FROM {$this->table} WHERE ic = :ic";
            $stmt = $this->conn->prepare($sql);
        }
        $stmt->bindParam(':ic', $ic, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }
}
