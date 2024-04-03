<?php
   include 'config/database.php';

    class Main extends Database{
        public function select($query){
            $result = $this->link->query($query);
            return $result;
        }

        public function insert($query){
            $insert = $this->link->query($query);
            if ($insert === TRUE) {
             return $insert;
            }
            else{
                return false;
            }
        }

        public function update($query){
            $update = $this->link->query($query);
             if ($update === TRUE) {
                 return $update;
             } else {
                 return $update;
             }
        }

        public function delete($query){
            $delete = $this->link->query($query);
             if ($delete === TRUE) {
                 return $delete;
             } else {
                 return false;
             }

        }
   }
