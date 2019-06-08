# taskshot
Taskshot is task management system.

- タスク詳細画面の作成
- ランクで左端にカラーマーク
- ページング
- 個人別設定画面の作成


## 検討事項

- ポモドーロタイマーを付けるか？
- タスク詳細設定画面UI
- End Tasks 一覧画面でのタスクの表示方法、ページング


## すること

- Rank, Date 順でのソート
- 設定画面の作成
- 表示の一行レイアウト化
- end tasks の日付を終了日順にする
- end tasks のページング
- task 項目のタグからのリンク
- sidemenuのタグクラウド

- (190608:end) bug: 日付の後ろに文字があると日付と一緒にdbに入ろうとする
- (181213:end) task line で Rank をコンボボックス化
- (181212:end) del ボタンの追加
- (181212:end) time 項目の追加
- (181212:end) bug:work にスペースがあると後半しか登録されない
- (181209:end) dayinput g日付入力パターンの追加
- (181129:end) 初期表示画面の日付ソート設定→全ページ日付優先でソート
- (181119:del) rank でクリッカブル編集にしたら、Combbox を表示するべきか？
 コンボボックスがなくなった


### 繰り返しタスク

繰り返しフィールドを追加して、終了時にフィールドチェックを行い、繰り返しフィールドがあれば、繰り返しシフィールドより日数を取得して新しい日付でタスクを追加登録

### タスクの追加

-!、ランク(0-3)、0：色なし(標準)、1：グレー、2：青、3：赤
-#、タグ、(未実装)[,] で複数指定
-@、場所、タスクを行う場所
-^、タスク期限、(未実装)スペースを開けて時間を指定可能


### タスク詳細画面

ダイアログでタスクの詳細を設定できる画面を作成する
- タスクの修正
- サブタスクの追加
- タスクの開始と終了ボタンで時間計測昨日
- 繰り返しタスクの設定


## できること

タスクの登録と削除、完了と復帰、終了したタスクの確認

タスクには、タスクID、重要度、タグ、開始予定日、開始時間、完了時間、タスク内容、完了フラグ、親タスク、タスク順位


### タスクの種類

taskist: タスクのリスト,集合体
tasks: flg, lank, tag, date, sttime, edtime, work、個別のタスク
task: task class
work: 作業そのもの
