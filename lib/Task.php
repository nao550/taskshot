<?php
/*

*/
namespace ftech;

use PDO;

class Task
{
    private $task;
    private $pdo;

    public function __construct($Task = '')
    {
        $this->task = $Task;

        $config = new Config;
        $this->pdo = $config->getPdo();
    }

    /*
     * userid の compflg が false をすべて取り出し
     * @param string $userid
     * @return array all task
     */
    public function getAllTask( $userid )
    {
        $sql = 'select * from tasks where compflg = false and userid = :userid  order by date asc';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->execute();

        return ($stmt->fetchAll());
    }

    /*
     *  Task を検索して、arrey で返す
     * @param $userid
     * @param $queryString
     * @return array
     */
    public function getTask($userid, $queryString)
    {
        $query = $this->queryFmt( $queryString );

        $sql = 'select * from tasks where userid = :userid';

        // EndTask の抽出
        if ( $query['rangemode'] == 'endtasks') {
            $sql .= " AND compflg = true ";
        } else {
            $sql .= " AND compflg = false ";
        }

        // 日付範囲の設定
        if (!(empty($query['stdate']))){
            $sql .= " and date >= :stdate ";
        }
        if (!(empty($query['eddate']))){
            $sql .= " and date <= :eddate ";
        }

        if (!(empty($query['tag']))) {
            $sql .= " and tag LIKE :tag " ;
        }

        // EndTask なら新しい日付からソート
        if ( $query['rangemode'] == 'endtasks') {
            $sql .= " order by date desc";
        } else {
            $sql .= " order by date asc";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);

        if (!(empty($query['stdate']))) {
            $stmt->bindValue(':stdate', $query['stdate'], PDO::PARAM_STR);
        }
        if (!(empty($query['eddate']))) {
            $stmt->bindValue(':eddate', $query['eddate'], PDO::PARAM_STR);
        }
        if (!(empty($query['tag']))) {
            $stmt->bindValue(':tag', '%'.$query['tag'].'%' , PDO::PARAM_STR);
        }

        $stmt->execute();

        return ($stmt->fetchAll());
    }

    /*
     * task を cd で1個取得
     * getOneTask
     * @param int
     * @return array
     */
    public function getOneTask($userid, $cd)
    {
        $sql = 'select * from tasks where userid = :userid and cd = :cd';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->bindValue(':cd', $cd, PDO::PARAM_STR);
        $stmt->execute();
        return ($stmt->fetchAll());
    }

    /*
     * task を一個追加
     * @param array $tasks
     * @return boolen
     */
    public function addTask($tasks)
    {
        $userid = $tasks['userid'];

        $qstr = new Querystr ;
        $tasks = $qstr->separateLineTask($tasks['linetask']);

        $date = $qstr->chkDate($tasks['date']);

        $sql = 'INSERT INTO tasks (userid, rank, tag, date, time, work, '.
           'compflg, regdate ) '.
           'VALUE (:userid, :rank, :tag, :date, :time, :work, 0, NOW());';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->bindValue(':rank', $tasks['rank'], PDO::PARAM_STR);
        $stmt->bindValue(':tag', $tasks['tag'], PDO::PARAM_STR);
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->bindValue(':time', $tasks['time'], PDO::PARAM_STR);
        $stmt->bindValue(':work', $tasks['work'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return 0;
        } else {
            echo 'error'.PHP_EOL;
        }

    }

    /*
     * task に終了フラグを設定
     * @param string $userid, int $cd
     * @return boolen
     */
    public function endTask($userid, $cd)
    {
        $sql = "UPDATE tasks set compflg='1', eddate = NOW() where cd=:cd and userid = :userid ;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cd', $cd, PDO::PARAM_STR);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch ( Exception $e ){
            echo 'Error: '. $e;
        }
        return 0;
    }

    /*
     * task を削除
     * @param int $cd
     * @return boolen
     */
    public function delTask($cd)
    {
        $sql = "DELETE FROM tasks WHERE cd=:cd ;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cd', $cd, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return 0;
        } else {
            return 1;
        }
    }


    /*
     * task に終了フラグを設定
     * @param int $cd
     * @return boolen
     */
    public function RevertTask($cd)
    {
        $sql = "UPDATE tasks set compflg='0', eddate = '' where cd=:cd ;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cd', $cd, PDO::PARAM_STR);
        $stmt->execute();
        return 0;
    }

    /*
     * タスクのアップデート
     * @param array
     * @return boolean
     */
    public function upTask($tasks){
        $sql = "UPDATE tasks set ";
        $sql .= " rank=:rank, ";
        $sql .= " tag=:tag, ";
        $sql .= " date=:date, ";
        $sql .= " rep=:rep, ";
        $sql .= " work=:work, ";
        $sql .= " memo=:memo ";
        $sql .= "WHERE cd=:cd ";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':rank', $tasks['rank'], PDO::PARAM_STR);
        $stmt->bindValue(':tag', $tasks['tag'], PDO::PARAM_STR);
        $stmt->bindValue(':date', $tasks['date'], PDO::PARAM_STR);
        $stmt->bindValue(':rep', $tasks['rep'], PDO::PARAM_STR);
        $stmt->bindValue(':work', $tasks['work'], PDO::PARAM_STR);
        $stmt->bindValue(':memo', $tasks['memo'], PDO::PARAM_STR);
        $stmt->bindValue(':cd', $tasks['cd'], PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch ( Exception $e ){
            echo 'Error: '. $e;
        }
        return 0;
    }

    /*
     * queryFmt クエリ文字列のフォーマット
     * @param array
     * @return array
     */
    private function queryFmt($str){
        $args = array(
            'rangemode' => FILTER_SANITIZE_ENCODED,
            'stdate' => FILTER_SANITIZE_ENCODED,
            'eddate' => FILTER_SANITIZE_ENCODED,
            'tag' => FILTER_SANITIZE_ENCODED
        );

        $query = filter_var_array( $str, $args );

        if ($query['rangemode'] == "endtask") {
        }

        if ($query['rangemode'] == "all") {
        }

        if ($query['rangemode'] == "runout") {
            $ed = date('Y-m-d', strtotime("-1 days"));
        }

        if ($query['rangemode'] == "today") {
            $ed = date('Y-m-d');
        }

        if ($query['rangemode'] == "next3day") {
            $st = date('Y-m-d');
            $ed = date('Y-m-d', strtotime("+3 days"));
        }

        if ($query['rangemode'] == "thisweek") {
            $st = date('Y-m-d');
            $ed = date('Y-m-1d', strtotime("+7 days"));
        }

        if ($query['rangemode'] == "thismonth") {
            $st = date('Y-m-d');
            $ed = date('Y-m-d', strtotime("+30 days"));
        }

        $array = array("rangemode" => $query['rangemode'],
                    "tag" => $query['tag'],
                    "stdate" => $st,
                    "eddate" => $ed
        );
        return $array;

    }

}
