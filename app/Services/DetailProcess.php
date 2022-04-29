<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
   * カテゴリ名を取得
   *
   * @param Collection $tasks 該当Taskのレコード群
   * @return string
   */
  public static function categoryName($tasks): string
  {
    if ($tasks->count() === 0) {
      $category = '登録がありません';
    } else {
      $i = 0;
      foreach ($tasks as $task) {
        if ($i >= 1) {
          break;
        }
        $category = $task->category->name;
        $i++;
      }
    }

    return $category;
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
}
