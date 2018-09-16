<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $id;
    public $email;
    public $nama;
    public $password;
    public $foto;
    public $ttl;
    public $kutipan;
    public $status;
    public $dibuat_pada;
    public $token;
    public $passwordL;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
        // read products
    function read(){

        // select all query
        $query = "SELECT
                        *
                FROM
                    " . $this->table_name . " 
                ORDER BY
                id DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    function countData(){

        // select all query
        $query = "SELECT 
                    u.id as id, 
                    u.email as email, 
                    c.catatanCount as catatan, 
                    j.jadwalCount as jadwal,
                    c.catatanCount + j.jadwalCount as total,
                    u.status as status
                    from 
                    user u 
                    left join 
                    (select user_id, count(user_id) as catatanCount from catatan group by user_id)
                    c on c.user_id = u.id 
                    left join 
                    (select user_id, count(user_id) as jadwalCount from jadwal group by user_id)
                    j on j.user_id = u.id ORDER BY total DESC;";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create product
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                 email=:email, nama=:nama, password=:password, foto=:foto, status=:status, dibuat_pada=:dibuat_pada, token=:token";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->foto=htmlspecialchars(strip_tags($this->foto));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->dibuat_pada=htmlspecialchars(strip_tags($this->dibuat_pada));
        $this->token=htmlspecialchars(strip_tags($this->token));

        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":foto", $this->foto);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":dibuat_pada", $this->dibuat_pada);
        $stmt->bindParam(":token", $this->token);
      
    
        // execute query
        if($stmt->execute()){
            
            if($this->mail()){
                return true;
            }else{
                return false;
            }
        }
    
        return false;
        
    }
    function mail(){
        $email_subject = "Website Contact From:  Tiem Schedule";
            $headers = "From: tiemschedule@tiemschedule.thekingcorp.org"."\r\n";
            $headers .= "Reply-To:noreply@tiemschedule.thekingcorp.org" . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            
            $message ='<html>';
            $message .='<body>';
                $message .='<div class="mail" style="margin: auto; width: 100%; max-width: 350px; text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 30px;">';
                    $message .='<div class="mail-header" style="color: white; background-color: #003365; width: 100%; font-size: 20px; padding: 20px; border-top-left-radius: 25px; border-top-right-radius: 25px;">';
                        $message .='<strong>VERIFIKASI EMAIL DARI <br/>TIEM SCHEDULE</strong>';
                    $message .='</div>';
                    $message .='<div class="mail-body" style="color: black; background-color:  #CFE7EA; width: 100%; padding: 20px;">';
                        $message .='<h1>Hallo '.$this->nama.', Silahkan lakukan verifikasi email anda dengan menekan tombol berikut </h1>';
                        $message .='<a href="https://tiemschedule.thekingcorp.org/mail/verifikasiEmail.php?token='.$this->token.'"><button style="background-image: linear-gradient(to left, #0025BC , #0071BC); width: 100%; text-align: center; margin: auto; min-height: 40px; color: white; font-size: 30px; cursor: pointer;">Klik disini</button></a>';
                    $message .='</div>';
                    $message .='<div class="mail-footer" style="color: black; background-color: #adadad; width: 100%; font-size: 20px;padding: 20px; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;">';
                        $message .='Apabila link tersebut bermasalah, silahkan akses url berikut:';
                        $message .='https://tiemschedule.thekingcorp.org/mail/verifikasiEmail.php?token='.$this->token;
                    $message .='</div>';
                $message .='</div>';
            $message .='</body>';
            $message .='</html>';
            
            if(mail($this->email,$email_subject,$message,$headers)){
                return true; 
            }else{
                return false;
            }
    }
    function readOne(){
 
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1
                    ";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
     
        // execute query
        $stmt->execute();
     
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        // set values to object properties
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->nama = $row['nama'];
        $this->foto = $row['foto'];
        $this->ttl = $row['ttl'];
        $this->kutipan = $row['kutipan'];
    }
    function sumData(){
           // select all query
           $query = "SELECT u.countData as user, c.countCatatan as catatan, j.countJadwal as jadwal FROM (select id, count(id) as countData from user) u left join (select user_id, count(user_id) as countCatatan from catatan) c on c.user_id = u.id left join (select user_id, count(user_id) as countJadwal from jadwal ) j on j.user_id = u.id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            $stmt->execute();

            return $stmt;
    }
    // update the product
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    email=:email, nama=:nama, foto=:foto, ttl=:ttl, kutipan=:kutipan
                WHERE
                    id=:id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->foto=htmlspecialchars(strip_tags($this->foto));
        $this->ttl=htmlspecialchars(strip_tags($this->ttl));
        $this->kutipan=htmlspecialchars(strip_tags($this->kutipan));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":foto", $this->foto);
        $stmt->bindParam(":ttl", $this->ttl);
        $stmt->bindParam(":kutipan", $this->kutipan);
        $stmt->bindParam(":id", $this->id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function updateWithPassword(){
          // update query
           // query to read single record
            $sql = "SELECT password FROM " . $this->table_name . " WHERE id = ?";

            $stmtP = $this->conn->prepare( $sql );

            $stmtP->bindParam(1, $this->id);

            $stmtP->execute();

            $row = $stmtP->fetch(PDO::FETCH_ASSOC);
            $this->passwordL=htmlspecialchars(strip_tags($this->passwordL));
          if(password_verify( $this->passwordL,$row['password'] )){
            $query = "UPDATE
                    " . $this->table_name . "
                SET
                    email=:email, nama=:nama, password=:password, foto=:foto, ttl=:ttl, kutipan=:kutipan
                WHERE
                    id=:id";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->nama=htmlspecialchars(strip_tags($this->nama));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->foto=htmlspecialchars(strip_tags($this->foto));
            $this->ttl=htmlspecialchars(strip_tags($this->ttl));
            $this->kutipan=htmlspecialchars(strip_tags($this->kutipan));
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind values
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":nama", $this->nama);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":foto", $this->foto);
            $stmt->bindParam(":ttl", $this->ttl);
            $stmt->bindParam(":kutipan", $this->kutipan);
            $stmt->bindParam(":id", $this->id);

            // execute the query
            if($stmt->execute()){
            return true;
            }

            return false;  
            
          }else{
            return false;
            
          }
    }
    function updateStatus(){
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    status=:status
                WHERE
                    id=:id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function updateByToken(){
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    status=1
                WHERE
                    token=:token";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        $this->token=htmlspecialchars(strip_tags($this->token));

        // bind values
        $stmt->bindParam(":token", $this->token);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function updatePasswordByToken($newToken){
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    password=:password, token=:newToken
                WHERE
                    token=:token";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        $this->token=htmlspecialchars(strip_tags($this->token));
        $newToken=htmlspecialchars(strip_tags($newToken));
        $this->password=htmlspecialchars(strip_tags($this->password));

        // bind values
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":newToken", $newToken);
        $stmt->bindParam(":token", $this->token);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    // delete the product
        function delete(){
        
            // delete query
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
            // prepare query
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind id of record to delete
            $stmt->bindParam(1, $this->id);
        
            // execute query
            if($stmt->execute()){
                return true;
            }
        
            return false;
            
        }

        // search products
        function search($keywords){
        
            // select all query
            $query = "SELECT
                        email
                    FROM
                        " . $this->table_name . " 
                    WHERE
                        email = ? ";
        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $keywords=htmlspecialchars(strip_tags($keywords));
        
            // bind
            $stmt->bindParam(1, $keywords);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        function getUserByToken($email){

                $query = "SELECT
                            token
                            FROM
                            " . $this->table_name . " 
                            WHERE
                            email LIKE ? ";

                // prepare query statement
                $stmt = $this->conn->prepare($query);

                // sanitize
                $email = htmlspecialchars(strip_tags($email));

                // bind
                $stmt->bindParam(1, $email);

                // execute query
                $stmt->execute();
                if($stmt->execute()){
                
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
         
                    // set values to object properties
                   return $row['token'];
                    
                }
                return false;
        }
        function dataById(){
            // delete query
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        
            // prepare query
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind id of record to delete
            $stmt->bindParam(1, $this->id);
        
            // execute query
            if($stmt->execute()){
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
                // set values to object properties
                $this->id = $row['id'];
                $this->email = $row['email'];
                $this->nama = $row['nama'];
                $this->foto = $row['foto'];
                $this->ttl = $row['ttl'];
                $this->kutipan = $row['kutipan'];
                return true;
            }
        
            return false;
        }
        function login(){
            $sql = "SELECT password FROM " . $this->table_name . " WHERE email = ?";

            $stmtP = $this->conn->prepare($sql);

            $stmtP->bindParam(1, $this->email);

            $stmtP->execute();

            $row = $stmtP->fetch(PDO::FETCH_ASSOC);
            $this->password=htmlspecialchars(strip_tags($this->password));
          if(password_verify( $this->password,$row['password'] )){
            $sql2 = "SELECT id FROM " . $this->table_name . " WHERE email = ?";

            $stmt = $this->conn->prepare( $sql2 );

            $stmt->bindParam(1, $this->email);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            session_start();
            $this->id = $row['id'];
            return true;
          }else{
            return false;
            
          }
        }
}

