１．すべての機能や画面のソースファイルは、srcフォルダ以下に集約する。
２．各機能や画面の利用は、必ずindex.phpを通して行う。
３．各機能や画面のURLは以下のような相対URLに統一。
　例えばeps_hoge.phpにアクセスしたい場合は、URLは以下のいずれかのように指定する
　「index.php?do=eps_hoge」 もしくは
  「?do=eps_hoge」　（index.phpはデフォルトページなので省略可）