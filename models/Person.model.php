<?php
require_once "../config/connection.php";

class Person extends Connection {

    public static function selectAll(){
        try {
            $sql = 'SELECT person.value_id, person.name, person.last_name, sex.name as sex, type_id.name as type_id
            FROM person 
            INNER JOIN sex ON person.sex = sex.id
            INNER JOIN type_id ON person.type_id = type_id.id';

            $stmt = Connection::getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $th) {
            return $th->getMessage();
        }
    }

    public static function selectById($id){
        try {
            $sql = "SELECT person.value_id, person.name, person.last_name, sex.name as sex, type_id.name as type_id
            FROM person
            INNER JOIN sex ON person.sex = sex.id
            INNER JOIN type_id ON person.type_id = type_id.id
            WHERE person.value_id = :id";
            $stmt = Connection::getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $th) {
            return $th->getMessage();
        }
    }

    public static function insertPerson($person){
        try {
            $sql = "INSERT INTO person (type_id, value_id, name, last_name, sex) VALUES(:type_id, :value_id, :name, :last_name, :sex)";
            $stmt = Connection::getConnection()->prepare($sql);
            $stmt->bindParam(':type_id', $person['type_id']);
            $stmt->bindParam(':value_id', $person['value_id']);
            $stmt->bindParam(':name', $person['name']);
            $stmt->bindParam(':last_name', $person['last_name']);
            $stmt->bindParam(':sex', $person['sex']);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $th) {
            return $th->getMessage();
        }
    }

    public static function updatePerson($person){
        try {
            $sql = "UPDATE person SET name = :name, last_name = :last_name, sex = :sex
            WHERE value_id = :value_id";
            $stmt = Connection::getConnection()->prepare($sql);
            $stmt->bindParam(':value_id', $person['value_id']);
            $stmt->bindParam(':name', $person['name']);
            $stmt->bindParam(':last_name', $person['last_name']);
            $stmt->bindParam(':sex', $person['sex']);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }

    public static function deleteById($id){
        try {
            $sql = "DELETE FROM person WHERE value_id = :id";
            $stmt = Connection::getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $th) {
            return $th->getMessage();
        }
    }
}