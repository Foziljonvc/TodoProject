<?php

declare(strict_types=1);

class Routes extends DB {

    public function returnIdTask (int $id) 
    {
        $stmt = $this->pdo->prepare("
            SELECT id
            FROM planuser
            ORDER BY id
            LIMIT 1 OFFSET :offset
        ");
        $stmt->bindValue(':offset', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $taskId = $result['id'];

            $stmt = $this->pdo->prepare("
                SELECT *
                FROM planuser
                WHERE id = :id
            ");
            $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function returnTasks () 
    {
        $stmt = $this->pdo->query('SELECT * FROM planuser');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveTask (string $task)
    {

        $stmt = $this->pdo->prepare("INSERT INTO planuser (todos, status) VALUES (:todos, :status)");
        $status = 0;
        $stmt->bindParam(':todos', $task);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    }

    public function checkedTaskId (int $id, int $checked)
    {
        if ($checked == 1) {
            $status = 1;

            $stmtSub = $this->pdo->prepare("
                SELECT id 
                FROM planuser 
                ORDER BY id 
                LIMIT 1 OFFSET :offset
            ");
            $stmtSub->bindValue(':offset', $id, PDO::PARAM_INT);
            $stmtSub->execute();
            $result = $stmtSub->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $id = $result['id'];
                
                $stmt = $this->pdo->prepare("
                    UPDATE planuser 
                    SET status = :status 
                    WHERE id = :id
                ");
                $stmt->bindValue(':status', $status, PDO::PARAM_INT);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } else {
            $status = 0;

            $offset = max($id, 0);
            
            $stmtSub = $this->pdo->prepare("
                SELECT id 
                FROM planuser 
                ORDER BY id 
                LIMIT 1 OFFSET :offset
            ");
            $stmtSub->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmtSub->execute();
            $result = $stmtSub->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $id = $result['id'];
            
                $stmt = $this->pdo->prepare("
                    UPDATE planuser 
                    SET status = :status 
                    WHERE id = :id
                ");
                $stmt->bindValue(':status', $status, PDO::PARAM_INT);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    }

    public function deleteTasksId (int $id)
    {
        $stmtSub = $this->pdo->prepare("
            SELECT id
            FROM planuser
            ORDER BY id
            LIMIT 1 OFFSET :offset
        ");
        $stmtSub->bindValue(':offset', $id, PDO::PARAM_INT);
        $stmtSub->execute();
    
        $result = $stmtSub->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $taskId = $result['id'];
            $stmtDelete = $this->pdo->prepare("
            DELETE FROM planuser
            WHERE id = :id
            ");
            $stmtDelete->bindParam(':id', $taskId, PDO::PARAM_INT);
            $stmtDelete->execute();
        }
    }
}   