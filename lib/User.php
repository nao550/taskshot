<?php
/*
   User クラス
   function __construct( array )
   string protected function encPasswd( string )
   boolen protected function chkInput( string, string )
   string protected function getUser( string, string )
   int function addUser ( string, string, int )
   boolen function chkLogin( string, string )
   boolen function existUser( string )
   int function cngUserPassword( string, string )
   int function getUserRank( string, string )
   int function delUser ( string, string )
*/

namespace ftech;

use PDO;

class User
{
    private $pdo = null;
    private static $logined = null;
    private $options = array();
    private $encoding = null;
    private $config;

    /* construct
     * @param array
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
        $this->config = new Config();
        $this->encoding = 'UTF-8';
        $this->pdo = $this->config->getPdo();
    }

    /* user id generater
     * @param string
     * @return string
     */
    protected function generateId($email)
    {
        $id = substr(hash('sha256', $email. rand()), 0, 16);
        return $id;
    }

    /* password string encrypter
     * @param string
     * @return string
     */
    protected function encPasswd($passwd)
    {
        return(password_hash($passwd, PASSWORD_DEFAULT));
    }

    /* check pasword and username string length and charactor.
     * username: min 6, max 30
     * password: min 8, max 300
     * @param string $user
     * @param string $passwd
     * @return boolen
     */
    private function chkInput($user, $passwd)
    {
        // 文字エンコーディングチェック
        if (!mb_check_encoding($user, $this->encoding)
           || !mb_check_encoding($passwd, $this->encoding)) {
            return false;
        }

        // 文字数と使用文字のチェックを行う,
        if (preg_match('/\A[a-z0-9!#<>:;&~@%+$"\'\*\^\(\)\[\]\|\/\.,_-]{6,30}\z/', $user) == 0) {
            return false;
        }

        //  文字数と使用文字のチェックを行う
        if (preg_match('/\A[a-z0-9!#<>:;&~@%+$"\'\*\^\(\)\[\]\|\/\.,_-]{8,300}\z/ui', $passwd) == 0) {
            return false;
        }
        return true;
    }

    /* Get user account.
     * @param string $email
     * @param string $password
     * @return string,
     */
    public function getUser($email, $password)
    {
        if (! $this->chkInput($email, $password)) {
            return false;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'select * from users where email = :email';
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':email', $email, PDO::PARAM_STR);
        $stm->execute();

        $row = $stm->fetch(PDO::FETCH_ASSOC);

        if (isset($row['password'])) {
            if (password_verify($password, $row['password'])) {
                return $row['id'];
            }
        } else {
            return '';
        }
    }

    /* Add user account.
     * @param string $email
     * @param string $password
     * @param int $rank
     * @return int
     */
    public function addUser($email, $password)
    {
        // ユーザ名、パスワードのながさチェック
        if (! $this->chkInput($email, $password)) {
            return 0;
        } else {
            $password = $this->EncPasswd($password);
            $id = $this->generateid($email);
        }

        // ユーザ名の重複チェック
        if ($this->ExistUser($email) >= 1) {
            return 0;
        }

        $sql = 'INSERT INTO users (id, email, password, regdate ) VALUES ( :id, :email, :password, NOW());';
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':id', $id, PDO::PARAM_STR);
        $stm->bindValue(':email', $email, PDO::PARAM_STR);
        $stm->bindValue('password', $password, PDO::PARAM_STR);

        return $stm->execute();
    }

    /* is logined check
     * @param string @username
     * @param string $password
     * @return boolen
     */
    public function chkLogin($username, $password)
    {
        $user = $this->getUser($username, $password);
        if (! empty($user)) {
            return true;
        };
        return false;
    }

    /* User exists check.
     * @param string $username
     * @return string $username
     */
    public function existUser($username)
    {
        $sql = 'select * from User where id = :id; ';
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':id', $username, PDO::PARAM_STR);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if ($stm->rowCount() === 1) {
            return true;
        } else {
            return false;
        }
    }

    /* Change user password.
     * @param string $username
     * @param string $oldpassword
     * @param string $newpassword
     * @return int
     */
    public function cngUserPassword($username, $oldpassword, $newpassword)
    {
        $id = $this->getUser($username, $oldpassword);
        if (!empty($id)) {
            $password = $this->EncPasswd($newpassword);
            $sql = 'UPDATE User SET psw = :psw  where id = :id ;';
            $stm = $this->pdo->prepare($sql);
            $stm->bindValue(':id', $username, PDO::PARAM_STR);
            $stm->bindValue(':psw', $password, PDO::PARAM_STR);
            return ($stm->execute());
        } else {
            return 0;
        }
    }

    /** check user rank.
     * @return string
     */
    public function getUserRank($username, $password)
    {
        $password = $this->EncPasswd($password);
        $sql = 'SELECT rank from User where id = :id AND psw = :psw;';
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':id', $username, PDO::PARAM_STR);
        $stm->bindValue(':psw', $password, PDO::PARAM_STR);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        return $row['rank'];
    }

    /** Delete user
     * @param string $username,
     * @param string $password
     * @return boolen;
     */
    public function delUser($username, $password)
    {
        if (! $this->chkInput($username, $password)) {
            return 0;
        } else {
            $password = $this->EncPasswd($password);
        }

        $sql = 'DELETE FROM User WHERE id = :id AND psw = :psw ;';
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':id', $username, PDO::PARAM_STR);
        $stm->bindValue(':psw', $password, PDO::PARAM_STR);
        $stm->execute();
        return $stm->rowCount();
    }
}
