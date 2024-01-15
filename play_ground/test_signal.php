<?php
// tick を使用しなければなりません
declare(ticks = 1);

// シグナルハンドラ関数
function sig_handler($signo, $sigInfo)
{

     switch ($signo) {
         case SIGTERM:
             // シャットダウンの処理
             exit;
             break;
         case SIGHUP:
             // 再起動の処理
             break;
         case SIGUSR1:
             echo "Hello! SIGUSR1 を受け取りました...\n";
             break;
         default:
             // それ以外のシグナルの処理
     }

}

echo "シグナルハンドラを設定します...\n";

// シグナルハンドラを設定します
pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGHUP,  "sig_handler");
pcntl_signal(SIGUSR1, "sig_handler");

// あるいは、オブジェクトも指定できます
// pcntl_signal(SIGUSR1, array($obj, "do_something"));

echo "自分自身に SIGUSR1 シグナルを送信します...\n";

$info = array();
pcntl_sigwaitinfo(array(SIGHUP), $info);

// SIGUSR1 をカレントのプロセス ID に送信します
// posix_* 関数を使うには posix 拡張モジュールが必要です
// posix_kill(posix_getpid(), SIGUSR1);

// while(TRUE) {}

echo "終了\n";

?>