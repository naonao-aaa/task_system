<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Task;
use App\Category;
use App\User;
use App\Status;

/**
 * 詳細処理クラス
 */
class DetailProcess
{
  /**
   * 検索機能（検索の条件をwhere句に付け足す処理）
   *
   * @param string $search 検索文字列
   * @param Builder $query
   * @return void
   */
  public static function search($search, $query): void
  {
    //もしキーワードがあったら
    if ($search !== null) {
      //全角スペースを半角に
      $search_split = mb_convert_kana($search, 's');
      //空白で区切る
      $search_split2 = preg_split('/[\s]+/', $search_split, -1, PREG_SPLIT_NO_EMPTY);
      //単語をループで回す
      foreach ($search_split2 as $value) {
        $query->where('name', 'like', '%' . $value . '%');
      }
    };
  }

  /**
   * task.indexで、最後に行うクエリの処理
   *
   * @param Builder $query
   * @return LengthAwarePaginator
   */
  public static function taskIndexLastQueryProcess($query): LengthAwarePaginator
  {
    $query->orderBy('created_at', 'desc');
    $tasks = $query->paginate(10);

    return $tasks;
  }

  /**
   * taskコントローラindexメソッドの、クエリ処理など
   *
   * @param integer $categoryId
   * @param string $search
   * @param integer $workUserId
   * @return Array
   */
  public static function taskIndexQuery($categoryId, $search, $workUserId): array
  {
    $query = Task::with(['status', 'category', 'adminUser', 'workUser']);  //Eagerローディング

    if (!empty($categoryId)) {       //if(isset($categoryId))とすると、空文字の時もtrueになるので、if句の処理が通ってしまうので。（emptyとissetの違いを復習すべき）//空文字列とそうでない時で分岐している。
      $query->where('category_id', $categoryId);   //カテゴリで条件指定

      $category = Category::find($categoryId)->name;   //カテゴリ名を取得

    } else {

      $category = 'すべてのカテゴリ';
    }

    if (!empty($workUserId)) {
      $query->where('work_user', $workUserId);  //担当者で条件指定
    }

    self::search($search, $query);   //検索キーワードの処理

    $tasks = self::taskIndexLastQueryProcess($query);   //$queryに最後に付け加える処理

    $index = array('tasks' => $tasks, 'category' => $category, 'categoryId' => $categoryId, 'workUserId' => $workUserId);
    return $index;
  }

  /**
   * Categoriesテーブルの全てのカテゴリを取得
   *
   * @return Collection
   */
  public static function categoryAll(): Collection
  {
    $categoryAll = Category::all();
    return $categoryAll;
  }

  /**
   * Userテーブルの全てのユーザーを取得
   *
   * @return Collection
   */
  public static function userAll(): Collection
  {
    $userAll = User::all();
    return $userAll;
  }

  /**
   * Statusテーブルの全てのステータスを取得
   *
   * @return Collection
   */
  public static function statusAll(): Collection
  {
    $statusAll = Status::all();
    return $statusAll;
  }
}
