<?php
require_once(dirname(__FILE__) . '/../include/bittorrent.php');
dbconn();

stdhead("银行系统");

if (!$CURUSER) {
    stdmsg("错误", "请先登录后访问。");
    stdfoot();
    exit;
}

$view_path = dirname(__FILE__) . '/../packages/nexusphp-bank-system/resources/views/bank.php';

if (!file_exists($view_path)) {
    stdmsg("错误", "视图文件丢失 (code: BS-01)，请联系管理员。");
    stdfoot();
    exit;
}

try {
    $repo = new \NexusPlugin\BankSystem\BankSystemRepository();
    $settings = $repo->getSettings();

    if (!($settings['enabled'] ?? false)) {
        stdmsg("提示", "银行系统暂未开放。");
        stdfoot();
        exit;
    }

    // 与大转盘保持一致：由仓库聚合页面数据
    $data = $repo->getDashboardData($CURUSER['id']);

} catch (\Exception $e) {
    stdmsg("错误", "加载银行数据时出错 (code: BS-02): " . $e->getMessage());
    stdfoot();
    exit;
}

require_once($view_path);

stdfoot();
?>
