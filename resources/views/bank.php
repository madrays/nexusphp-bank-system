<?php
// This file is now a pure view and expects variables to be passed from the controller.
// Expected variables: $CURUSER, $settings, $bonusName, $userBonus, $userHourlyBonus, $maxLoanAmount, $currentLoan, $deposits, $loanTerms, $fixedDepositRates

// 获取魔力别名
$bonusName = $bonusName ?? '魔力';
?>

<style>
:root{--bg:#f5f6f8;--card:#fff;--text:#0b0c0f;--muted:#6b7280;--primary:#0a84ff;--primary-dark:#0063cc;--success:#34c759;--warning:#ffcc00;--danger:#ff3b30;--radius:14px;--shadow:0 16px 32px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.04)}
.bank-container{max-width:1200px;margin:0 auto;padding:28px;background:var(--bg)}
/* 顶部概览：用户维度 / 站点维度 */
.overview-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px}
@media (max-width: 900px){.overview-grid{grid-template-columns:1fr}}
.overview-card{background:var(--card);border-radius:12px;box-shadow:var(--shadow);padding:14px 16px}
.overview-grid{align-items:stretch}
.overview-title{font-weight:800;margin-bottom:8px;color:#111;display:flex;align-items:center;gap:8px}
.kv-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px}
@media (max-width:1100px){.kv-grid{grid-template-columns:repeat(2,1fr)}}
@media (max-width:640px){.kv-grid{grid-template-columns:1fr}}
 .kvv{background:#f8fafc;border:1px solid #eef2f7;border-radius:10px;padding:10px 12px;display:flex;flex-direction:column;min-height:64px}
 .kvv .k{color:#6b7280;font-size:12px;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
 .kvv .v{font-weight:800;color:#111;font-size:14px;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
 .unit-hint{margin-top:4px;color:#6b7280;font-size:12px}

.bank-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card{background:var(--card);padding:14px;border-radius:var(--radius);box-shadow:var(--shadow);text-align:center}

.stat-value {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.stat-label {
    color: #666;
    font-size: 12px;
}

.bank-sections {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.bank-section{background:var(--card);padding:28px;border-radius:var(--radius);box-shadow:var(--shadow)}

 .section-title{font-size:18px;font-weight:700;margin:0 0 14px 0;color:#111;border:none;padding:0;display:flex;align-items:center;gap:8px}
 .section-title:before{content:"";display:inline-block;width:8px;height:8px;border-radius:50%;background:var(--primary)}

.form-group {
    margin-bottom: 15px;
}

.form-label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.form-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.form-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    background: white;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary{background:var(--primary);color:#fff}.btn-primary:hover{background:var(--primary-dark)}

.btn-success{background:var(--success);color:#fff}.btn-success:hover{opacity:.95}

.btn-warning{background:var(--warning);color:#212529}.btn-warning:hover{opacity:.95}

.records-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.records-table th,
.records-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.records-table th{background:#f1f3f5;font-weight:600}

.status-active { color: #28a745; }
.status-paid { color: #6c757d; }
.status-overdue { color: #dc3545; }
.status-matured { color: #17a2b8; }
.status-withdrawn { color: #6c757d; }

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success{color:#0a4;background-color:#e9f9ef;border-color:#c6f0d3}

.alert-danger{color:#b00020;background-color:#fdecee;border-color:#f6c7cd}

@media (max-width: 768px) {
    .bank-sections {
        grid-template-columns: 1fr;
    }
    
    .bank-stats {
        grid-template-columns: 1fr;
    }
}

/* 图表、时间线、卡片网格样式 */
.panel{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);padding:18px;margin-bottom:12px}
.panel-title{font-weight:700;margin-bottom:12px;color:#111}
.rules-list{margin:0;padding-left:18px;line-height:1.6;color:#4b5563}
.rules-list li{margin:4px 0}
.rate-grid{display:flex;flex-wrap:wrap;gap:8px;margin-top:6px}
.rate-chip{background:#f1f5f9;color:#334155;border:1px solid #e2e8f0;border-radius:6px;padding:4px 10px;font-size:12px}
.chart{width:100%;height:140px;position:relative}
.timeline{list-style:none;margin:0;padding:0}
.timeline li{display:flex;gap:12px;align-items:flex-start;padding:10px 0;border-bottom:1px solid #eee}
.timeline li:last-child{border-bottom:none}
.dot{width:10px;height:10px;border-radius:50%;background:var(--primary);margin-top:6px}
 .timeline-box{max-height:160px;overflow:auto;padding-right:6px}
.muted{color:#6b7280}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px}
.deposit-card{background:var(--card);border-radius:12px;box-shadow:var(--shadow);padding:16px}
.badge{display:inline-block;padding:3px 8px;border-radius:999px;background:#eef2ff;color:#1d4ed8;font-size:12px}
.badge-info{background:#e0f2fe;color:#0369a1}
.badge-warning{background:#fef3c7;color:#92400e}
.badge-danger{background:#fee2e2;color:#991b1b}
 .table-box{max-height:240px;overflow:auto;border:1px solid #eef2f7;border-radius:10px}
.table-box::-webkit-scrollbar{width:0;height:0}
.table{width:100%;border-collapse:collapse}
.table th,.table td{padding:10px 12px;border-bottom:1px solid #eef2f7;text-align:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.table th{background:#f8fafc;color:#111;font-weight:600}
.op-col{text-align:right}
/* 行布局容器 */
.row-2,.row-4{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;align-items:stretch;grid-auto-rows:1fr}
@media (max-width:900px){.row-2,.row-4{grid-template-columns:1fr}}
.col-left{display:flex;flex-direction:column;gap:16px}
.panel-fill{height:100%}
.h-100{height:100%}
.sub-title{font-weight:700;margin:10px 0 8px 0;color:#111}
.row-spacer{height:12px}
.row-2 > div > .bank-section{padding-bottom:8px;display:flex;flex-direction:column;gap:12px}
.row-2 > div > .bank-section > *:last-child{margin-bottom:0}
.mini-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:8px}
.mini-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
@media (max-width:900px){.mini-grid-3{grid-template-columns:repeat(2,1fr)}}
@media (max-width:640px){.mini-grid-3{grid-template-columns:1fr}}
.mini{background:#f8fafc;border:1px solid #eef2f7;border-radius:10px;padding:6px 8px;display:flex;flex-direction:column;gap:4px}
.mini,.mini-fixed{height:64px}
.mini .top{display:flex;justify-content:space-between;gap:8px}
.mini .amt{font-weight:800;color:#111;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.mini .meta{display:none}
.mini .tag{display:none}
.dop{color:#fff}
.dop .k{color:rgba(255,255,255,.9)!important}
.dop .meta{color:rgba(255,255,255,.85)!important}
.dop .tag{background:rgba(255,255,255,.18);color:#fff;border-color:rgba(255,255,255,.25)}
.dop-1{background:linear-gradient(135deg,rgba(255,107,107,.85),rgba(255,142,83,.85))!important;border-color:transparent}
.dop-2{background:linear-gradient(135deg,rgba(106,133,255,.85),rgba(0,194,255,.85))!important;border-color:transparent}
.dop-3{background:linear-gradient(135deg,rgba(66,230,149,.85),rgba(59,178,184,.85))!important;border-color:transparent}
.dop-4{background:linear-gradient(135deg,rgba(246,211,101,.85),rgba(253,160,133,.85))!important;border-color:transparent}
.dop-5{background:linear-gradient(135deg,rgba(161,140,209,.85),rgba(251,194,235,.85))!important;border-color:transparent}
.dop-6{background:linear-gradient(135deg,rgba(94,252,232,.85),rgba(115,110,254,.85))!important;border-color:transparent}
.dop-7{background:linear-gradient(135deg,rgba(240,147,251,.85),rgba(245,87,108,.85))!important;border-color:transparent}
.dop-8{background:linear-gradient(135deg,rgba(132,250,176,.85),rgba(143,211,244,.85))!important;border-color:transparent}
.dop-9{background:linear-gradient(135deg,rgba(252,207,49,.85),rgba(245,85,85,.85))!important;border-color:transparent}
.stat-card.gradient{color:#fff;position:relative;overflow:hidden}
.stat-card.gradient .icon{font-size:18px;opacity:.9;margin-bottom:6px;display:inline-block}
.stat-card.gradient.blue{background:linear-gradient(135deg,#60a5fa,#3b82f6)}
.stat-card.gradient.purple{background:linear-gradient(135deg,#a78bfa,#8b5cf6)}
.stat-card.gradient.green{background:linear-gradient(135deg,#34d399,#10b981)}
.stat-card.gradient.amber{background:linear-gradient(135deg,#fbbf24,#f59e0b)}
.deposit-card:hover{transform:translateY(-2px);box-shadow:0 20px 40px rgba(0,0,0,.08),0 6px 18px rgba(0,0,0,.06)}

/* 贷款概要卡（重新设计，确保完整显示） */
.loan-summary{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;margin-bottom:16px;border-left:4px solid #60a5fa;background:linear-gradient(180deg,#fbfdff,#ffffff)}
.loan-summary .loan-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:8px}
.loan-summary .loan-title{font-weight:800;color:#111;font-size:16px;display:flex;align-items:center;gap:8px}
.loan-summary .loan-title .emoji{font-size:18px}
.loan-summary .loan-status{background:#e0f2fe;color:#0369a1;padding:4px 8px;border-radius:6px;font-size:12px;font-weight:600}
/* 基本信息紧凑三行显示 */
.loan-basic-info{margin-bottom:12px;padding:8px 0}
.loan-basic-info .basic-info-row{display:flex;align-items:center;padding:4px 0;border-bottom:1px solid #f1f5f9}
.loan-basic-info .basic-info-row:last-child{border-bottom:none}
.loan-basic-info .basic-label{font-size:13px;color:#64748b;font-weight:500;min-width:80px}
.loan-basic-info .basic-value{font-size:14px;font-weight:600;color:#0f172a;word-break:break-all;flex:1}

.loan-summary .loan-info{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-bottom:12px}
.loan-summary .info-item{background:#f8fafc;border:1px solid #eef2f7;border-radius:8px;padding:10px 12px}
.loan-summary .info-label{font-size:12px;color:#6b7280;margin-bottom:4px;font-weight:500}
.loan-summary .info-value{font-size:14px;font-weight:700;color:#111;word-break:break-all}

/* 关键信息三行显示 */
.loan-key-info{background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;padding:12px;margin-bottom:12px}
.loan-key-info .key-info-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #e2e8f0}
.loan-key-info .key-info-row:last-child{border-bottom:none}
.loan-key-info .key-info-label{font-size:13px;color:#475569;font-weight:600;min-width:120px}
.loan-key-info .key-info-value{font-size:15px;font-weight:800;color:#0f172a;text-align:right;word-break:break-all;flex:1;margin-left:12px}
.loan-summary .loan-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
.loan-summary .action-btn{padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all 0.2s}
.loan-summary .action-btn.primary{background:#0a84ff;color:#fff}
.loan-summary .action-btn.primary:hover{background:#0063cc}
.loan-summary .action-btn.secondary{background:#f1f5f9;color:#334155;border:1px solid #e2e8f0}
.loan-summary .action-btn.secondary:hover{background:#e2e8f0}
@media (max-width:768px){.loan-summary .loan-info{grid-template-columns:1fr}.loan-summary .loan-actions{justify-content:stretch}.loan-summary .action-btn{flex:1;min-width:120px}}

/* 小徽标 pill */
.pill-row{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:4px}
.pill{background:#eef2ff;color:#1d4ed8;border:1px solid #dbeafe;border-radius:999px;padding:2px 8px;font-size:12px}
.pill.blue{background:#e0f2fe;color:#0369a1;border-color:#bae6fd}
.pill.green{background:#dcfce7;color:#166534;border-color:#bbf7d0}
.pill.red{background:#fee2e2;color:#991b1b;border-color:#fecaca}
.pill.gray{background:#f1f5f9;color:#475569;border-color:#e2e8f0}
.dep-meta{font-size:12px;color:#64748b;margin-top:6px}
.deposit-card .dep-meta + .dep-meta{margin-top:4px}
/* 强调色（与定期卡一致风格） */
.value-strong{font-weight:800;color:#0f172a}
.value-blue{color:#0ea5e9}
.value-emerald{color:#059669}
.value-rose{color:#dc2626}

/* 站点概览紧凑样式 */
.overview-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-top:12px}
.stat-item{background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px;text-align:center}
.stat-item .stat-label{font-size:12px;color:#6b7280;margin-bottom:4px;font-weight:500}
.stat-item .stat-value{font-size:18px;font-weight:700;background:linear-gradient(135deg,#667eea,#764ba2,#f093fb,#f5576c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:2px}
.stat-item .stat-hint{font-size:11px;color:#9ca3af}

/* 定期存款折叠样式 */
.deposits-container{position:relative}
.deposits-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:16px}
.deposits-hidden{display:none;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:16px;margin-top:16px}
.deposits-toggle{text-align:center;margin-top:16px}
.deposits-toggle .btn{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:6px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;cursor:pointer;transition:all 0.2s}
.deposits-toggle .btn:hover{background:#e2e8f0;color:#0f172a}
.deposits-toggle .btn .toggle-icon{transition:transform 0.2s}
.deposits-toggle .btn.expanded .toggle-icon{transform:rotate(180deg)}

/* 使用规则与说明样式 - 紧凑版 */
.rules-section{margin-bottom:16px;padding:12px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0}
.rules-title{font-size:14px;font-weight:700;color:#1e293b;margin-bottom:12px;display:flex;align-items:center;gap:6px}
.rules-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px}
.rule-item{background:#fff;border:1px solid #e2e8f0;border-radius:6px;padding:8px}
.rule-label{font-size:12px;font-weight:600;color:#475569;margin-bottom:4px}
.rule-content{font-size:13px;color:#0f172a;line-height:1.4}
.formula{font-family:monospace;background:#f1f5f9;padding:2px 6px;border-radius:3px;font-size:12px}

.rate-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px}
.rate-card{background:#fff;border:1px solid #e2e8f0;border-radius:6px;padding:10px;text-align:center}
.rate-header{font-size:12px;font-weight:600;color:#475569;margin-bottom:6px}
.rate-value{font-size:14px;font-weight:700;color:#0f172a;margin-bottom:6px}
.rate-item{font-size:11px;color:#64748b;margin:1px 0}
.rate-desc{font-size:11px;color:#6b7280;margin-top:6px}

.interest-flow{display:flex;justify-content:space-around;gap:12px;flex-wrap:wrap}
.flow-item{display:flex;align-items:center;gap:6px;background:#fff;padding:8px 12px;border-radius:6px;border:1px solid #e2e8f0;min-width:160px}
.flow-icon{font-size:16px}
.flow-text{font-size:12px;font-weight:500;color:#0f172a}

.tips-list{background:#fff;border:1px solid #e2e8f0;border-radius:6px;padding:10px}
.tip-item{font-size:12px;color:#475569;line-height:1.4;margin-bottom:4px;padding-left:6px}
.tip-item:last-child{margin-bottom:0}

@media (max-width:768px){
  .rules-grid{grid-template-columns:1fr}
  .rate-grid{grid-template-columns:1fr}
  .interest-flow{flex-direction:column;align-items:stretch}
  .flow-item{min-width:auto}
}

/* 统一小指标网格（非胶囊） - 已弃用，保留以防其他地方使用 */
.metrics{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin:8px 0 10px}
.metric{background:#f8fafc;border:1px solid #eef2f7;border-radius:10px;padding:10px 12px;min-height:64px;display:flex;flex-direction:column}
.metric .m-k{font-size:12px;color:#6b7280;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.metric .m-v{font-weight:800;font-size:16px;color:#111;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.metric .m-s{font-size:12px;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

/* 暗色模式 */
@media (prefers-color-scheme: dark){
  :root{--bg:#0c0d0f;--card:#15161a;--text:#e5e7eb;--muted:#9aa0a6;--primary:#0a84ff;--primary-dark:#0a6cd6;--success:#32d74b;--warning:#ffd60a;--danger:#ff453a}
  .bank-header{background:linear-gradient(135deg,#0f1013,#090a0c)}
  .section-title{color:#e5e7eb;border-bottom-color:#23252b}
  .records-table td,.records-table th{border-bottom-color:#23252b}
}

/* 双栏布局：规则 与 趋势面板并排 */
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media (max-width: 900px){.grid-2{grid-template-columns:1fr}}

/* 统一版块头部（极简风） */
.section-head{display:flex;align-items:center;gap:8px;color:#111;padding:0;margin:0 0 12px 0;border-bottom:1px solid #eef2f7}
.section-head .head-icon{font-size:16px;opacity:.9;color:#64748b}
.section-head .head-title{font-weight:700;letter-spacing:.2px;padding:6px 0}

/* 紧凑行表单布局 */
.form-row{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
.form-field{flex:1 1 300px;max-width:520px;min-width:260px}
.form-field .form-input,.form-field .form-select,.form-field select{width:100%;height:42px;box-sizing:border-box}
.btn{white-space:nowrap;height:42px;display:inline-flex;align-items:center;justify-content:center;padding:0 16px;border-radius:10px}

/* 选项卡与模态框 */
.tabs{display:flex;gap:18px;margin:0 0 12px 0}
.tab-btn{padding:8px 6px 10px 6px;border:none;background:transparent;color:#6b7280;font-weight:600;cursor:pointer;border-bottom:2px solid transparent}
.tab-btn:hover{color:#111}
.tab-btn.active{color:#111;border-bottom-color:var(--primary)}
.hidden{display:none !important}
.action-bar{display:flex;gap:12px;flex-wrap:wrap}
.modal{position:fixed;inset:0;background:rgba(0,0,0,.5);display:none;align-items:center;justify-content:center;z-index:9999}
.modal.show{display:flex}
.modal-card{background:var(--card);border-radius:14px;box-shadow:var(--shadow);width:min(520px,92%);padding:20px}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.close{background:transparent;border:none;font-size:22px;cursor:pointer;color:#6b7280}
/* Mesh 风格信息区（非传统卡片） */
.slab{height:100%;padding:16px 18px;border-radius:16px;background:radial-gradient(1200px 400px at -10% -20%,#eef2ff 0%,#ffffff 42%),radial-gradient(900px 360px at 120% 120%,#f1f5f9 0%,#ffffff 50%);border:0}
.slab-head{font-weight:800;color:#0b0c0f;margin:0 0 12px 0;letter-spacing:.3px}
.metrics-lite{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.gauge{padding:10px 12px;border-radius:12px;background:linear-gradient(180deg,#ffffff, #f8fafc);border:1px solid #eef2f7}
.gauge .v{font-size:18px;font-weight:800;color:#0b0c0f}
.gauge .k{font-size:12px;color:#6b7280;margin-top:2px}
.chips{display:flex;flex-wrap:wrap;gap:8px}
.chip{background:#f1f5f9;border:1px solid #e2e8f0;color:#334155;border-radius:999px;padding:4px 10px;font-size:12px}
.bullets{margin:8px 0 0 18px;color:#4b5563;line-height:1.6}
/* 行信息（无卡片、无胶囊） */
.rows{display:flex;flex-direction:column;gap:10px}
.row-line{display:grid;grid-template-columns:160px 1fr;align-items:baseline;border-bottom:1px solid #eef2f7;padding:6px 0}
.row-line:last-child{border-bottom:none}
.row-line .name{color:#64748b;font-size:12px}
.row-line .value{display:flex;align-items:baseline;gap:10px;flex-wrap:wrap}
.num-grad{font-size:26px;font-weight:800;background:linear-gradient(90deg,#0ea5e9,#6366f1);-webkit-background-clip:text;background-clip:text;color:transparent;letter-spacing:.2px}
.hint{font-size:12px;color:#6b7280}
.mono{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,monospace;font-size:12px;color:#334155}
.rate-lines{margin-top:2px;color:#334155}
.rate-lines .item{font-size:12px}
.rate-lines .item + .item:before{content:"｜";margin:0 10px;color:#cbd5e1}
/* 顶部信息栏 */
.topbar{background:linear-gradient(90deg,#eef2ff,#f8fbff);border:1px solid #e2e8f0;border-radius:12px;padding:10px 12px;margin-bottom:12px;display:flex;gap:12px;align-items:center;flex-wrap:wrap;box-shadow:0 6px 14px rgba(14,118,255,.03)}
.topbar-title{font-weight:800;color:#0b0c0f}
.topbar-chips{display:flex;gap:8px;overflow:auto;padding:2px 0}
.badge-soft{display:inline-flex;align-items:center;gap:6px;border-radius:8px;padding:3px 8px;border:1px solid transparent;font-size:12px;white-space:nowrap}
.soft-blue{background:#eef2ff;border-color:#e2e8f0;color:#1d4ed8}
.soft-amber{background:#fff7ed;border-color:#fde68a;color:#92400e}
.soft-green{background:#ecfdf5;border-color:#a7f3d0;color:#065f46}
/* 数值强调（护眼配色） */
.num{font-variant-numeric:tabular-nums}
.num-pos{color:#0f766e}
.num-warn{color:#b45309}
.num-neg{color:#b91c1c}
.num-info{color:#1d4ed8}
</style>

<div class="bank-container">
    <?php if (!empty($_SESSION['bank_message'])): $msg = $_SESSION['bank_message']; unset($_SESSION['bank_message']); ?>
        <div class="alert <?= $msg['type'] === 'success' ? 'alert-success' : 'alert-danger' ?>">
            <?= htmlspecialchars($msg['text']) ?>
        </div>
    <?php endif; ?>
    <!-- 顶部到期横幅（全宽） -->
    <?php 
      $loanDueText = '';
      if (!empty($data['currentLoan'])) {
        $dueTs = strtotime($data['currentLoan']['due_date']);
        $days = $dueTs ? max(0, ceil(($dueTs - time())/86400)) : null;
        $loanDueText = '贷款：'.($days!==null?('剩余 '.$days.' 天到期'):'到期日 -').' ｜ 欠款 '.number_format($data['currentLoan']['remaining_amount'] ?? 0,2).' '.($data['bonusName'] ?? '');
      }
      $mItems = $data['maturingDeposits'] ?? [];
      $mCount = is_array($mItems) ? count($mItems) : 0;
    ?>
    <div class="topbar">
      <span class="topbar-title">到期提醒</span>
      <div class="topbar-chips">
        <?php if ($loanDueText): ?>
          <span class="badge-soft soft-amber"><?= htmlspecialchars($loanDueText) ?></span>
        <?php endif; ?>
        <?php if ($mCount === 1): $item = $mItems[0]; $daysLeft = max(0, ceil((strtotime($item['maturity_date']) - time())/86400)); ?>
          <span class="badge-soft soft-green">定期 · <?= number_format($item['amount'],2) ?> <?= $data['bonusName'] ?> · 剩 <?= $daysLeft ?> 天</span>
        <?php elseif ($mCount === 2): foreach (array_slice($mItems, 0, 2) as $item): $daysLeft = max(0, ceil((strtotime($item['maturity_date']) - time())/86400)); ?>
          <span class="badge-soft soft-green">定期 · <?= number_format($item['amount'],2) ?> <?= $data['bonusName'] ?> · 剩 <?= $daysLeft ?> 天</span>
        <?php endforeach; elseif ($mCount > 2): ?>
          <span class="badge-soft soft-blue">定期：未来 7 日<?= $mCount ?> 笔到期</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- 顶部概览：用户维度 / 站点维度 -->
    <div class="overview-grid">
        <div class="overview-card">
            <div class="overview-title">👤 我的资产概览</div>
            <div class="unit-hint">单位：<?= $data['bonusName'] ?></div>
            <div class="mini-grid-3">
                <?php $dop=1; $kvItems=[
                  ['k'=>'总资产','v'=>number_format($data['userOverview']['total_asset'] ?? 0,2)],
                  ['k'=>'净资产','v'=>number_format($data['userOverview']['net_asset'] ?? 0,2)],
                  ['k'=>'站内余额','v'=>number_format($data['userOverview']['bonus'] ?? 0,2)],
                  ['k'=>'活期余额','v'=>number_format($data['userOverview']['demand_balance'] ?? 0,2)],
                  ['k'=>'在投定期','v'=>number_format($data['userOverview']['fixed_active_total'] ?? 0,2).'（'.(int)($data['userOverview']['fixed_active_count'] ?? 0).' 笔）'],
                  ['k'=>'贷款负债','v'=>number_format($data['userOverview']['loan_outstanding'] ?? 0,2)],
                  ['k'=>'时魔（每小时）','v'=>number_format($data['userOverview']['hourly_bonus'] ?? 0,3)],
                  ['k'=>'最大可贷','v'=>number_format($data['maxLoanAmount'] ?? 0,2)],
                  ['k'=>'在投笔数','v'=>(int)($data['userOverview']['fixed_active_count'] ?? 0).' 笔']
                ]; foreach($kvItems as $it): ?>
                <div class="mini mini-fixed">
                  <div class="top"><div class="k"><?= $it['k'] ?></div></div>
                  <div class="amt"><?= $it['v'] ?></div>
                </div>
                <?php $dop=$dop>=9?1:$dop+1; endforeach; ?>
            </div>
        </div>
        <div class="overview-card">
            <div class="overview-title">📈 近期利息</div>
            <div class="unit-hint">单位：<?= $data['bonusName'] ?></div>
            <div class="mini-grid-3">
              <?php 
                $riList = $data['recentInterest'] ?? [];
                $map = [];
                foreach ($riList as $row) { $map[$row['date']] = $row['amount']; }
                for ($i=8,$idx=1; $i>=0; $i--, $idx++) {
                  $d = date('Y-m-d', strtotime("-$i day"));
                  $amt = isset($map[$d]) ? $map[$d] : 0;
              ?>
                <div class="mini mini-fixed">
                  <div class="top">
                    <div class="k" style="font-size:12px;color:#6b7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= $d ?></div>
                  </div>
                  <div class="amt"><?= number_format($amt, 2) ?></div>
        </div>
              <?php } ?>
        </div>
        </div>
    </div>

    <!-- 规则与到期提醒将移至第4/第2行 -->

    <!-- 第二行：左列（贷款 + 到期提醒），右列（存款） -->
    <div class="row-2">
      <div>
        <div class="bank-section">
            <div class="section-head"><span class="head-icon">💰</span><div class="head-title">贷款服务</div></div>
            <?php if ($data['currentLoan']): ?>
                <?php 
                  $loan = $data['currentLoan'];
                  $daysLeft = $loan['due_date'] ? max(0, ceil((strtotime($loan['due_date']) - time())/86400)) : null;
                  $dailyRate = (float)($loan['interest_rate'] ?? 0);
                  $statusKey = $loan['status'] ?? '';
                  $statusCn = ['active'=>'进行中','paid'=>'已结清','overdue'=>'已逾期','defaulted'=>'违约'][$statusKey] ?? $statusKey;
                ?>
                <div class="loan-summary">
                  <div class="loan-header">
                    <div class="loan-title">
                      <span class="emoji">💰</span>
                      <span>银行贷款详情</span>
                    </div>
                    <div class="loan-status"><?= htmlspecialchars($statusCn) ?></div>
                  </div>
                  
                  <div class="loan-basic-info">
                    <div class="basic-info-row">
                      <span class="basic-label">贷款金额：</span>
                      <span class="basic-value"><?= number_format($loan['amount'],2) ?> <?= $data['bonusName'] ?></span>
                    </div>
                    <div class="basic-info-row">
                      <span class="basic-label">到期时间：</span>
                      <span class="basic-value"><?= htmlspecialchars($loan['due_date']) ?><?= $daysLeft!==null?(' (剩余 '.$daysLeft.' 天)'):'' ?></span>
                    </div>
                    <div class="basic-info-row">
                      <span class="basic-label">日利率：</span>
                      <span class="basic-value">
                        <?php 
                        $baseRate = (float)($loan['interest_rate'] ?? 0) * 100;
                        if ($loan['status'] === 'overdue') {
                          $penaltyRate = (float)($data['settingsForDisplay']['overdue_penalty_rate'] ?? 0) * 100;
                          $totalRate = $baseRate + $penaltyRate;
                          echo number_format($baseRate, 2) . '% + ' . number_format($penaltyRate, 2) . '%罚息 = ' . number_format($totalRate, 2) . '%';
                        } else {
                          echo number_format($baseRate, 2) . '%';
                        }
                        ?>
                      </span>
                    </div>
                  </div>
                  
                  <?php $accr = (float)($data['loanAccrued'] ?? 0); $payoff = $data['loanPayoff'] ?? null; ?>
                  <div class="loan-key-info">
                    <div class="key-info-row">
                      <div class="key-info-label">当前欠款</div>
                      <div class="key-info-value"><?= number_format($loan['remaining_amount'],2) ?> <?= $data['bonusName'] ?></div>
                    </div>
                    <div class="key-info-row">
                      <div class="key-info-label">应计利息（今日至今）</div>
                      <div class="key-info-value"><?= number_format($accr,2) ?> <?= $data['bonusName'] ?></div>
                    </div>
                    <div class="key-info-row">
                      <div class="key-info-label">一次性结清需</div>
                      <div class="key-info-value"><?= $payoff!==null?number_format($payoff,2):'-' ?> <?= $data['bonusName'] ?></div>
                    </div>
                  </div>
                  
                  <div class="loan-actions">
                    <button type="button" class="action-btn primary" onclick="document.getElementById('loanHistory').scrollIntoView({behavior:'smooth',block:'start'})">查看贷款历史</button>
                  </div>
                </div>
                <div class="tabs">
                    <button class="tab-btn active" type="button" onclick="showLoanTab('repay')">提前还款（一次性结清）</button>
                </div>
                <div id="loan-tab-repay">
                <form method="post" action="/bank-repay.php">
                    <div class="form-group">
                            <label class="form-label">结清金额</label>
                            <input type="number" name="amount" id="repay_amount" class="form-input" step="0.01" min="0.01" max="<?= $data['currentBonus'] ?>" placeholder="输入一次性结清金额" required>
                            <small>当前欠款 + 应计利息至今 = <?= $payoff!==null?number_format($payoff,2):'-' ?> <?= $data['bonusName'] ?></small>
                        </div>
                        <div class="action-bar">
                          <?php if($payoff!==null): ?>
                          <button type="button" class="btn" onclick="document.getElementById('repay_amount').value='<?= number_format($payoff,2,'.','') ?>'">填充应还</button>
                          <?php endif; ?>
                          <button type="submit" class="btn btn-success">立即结清</button>
                    </div>
                </form>
                </div>
            <?php else: ?>
                <div class="tabs">
                    <button class="tab-btn active" type="button" onclick="showLoanTab('apply')">申请贷款</button>
                </div>
                <div id="loan-tab-apply">
                <form method="post" action="/bank-loan.php">
                    <div class="form-group">
                        <label class="form-label">贷款金额</label>
                            <input type="number" name="amount" class="form-input" step="0.01" min="<?= $data['minLoanAmount'] ?>" max="<?= $data['maxLoanAmount'] ?>" placeholder="输入贷款金额" required>
                        <small>最小: <?= number_format($data['minLoanAmount']) ?> <?= $data['bonusName'] ?>，最大: <?= number_format($data['maxLoanAmount']) ?> <?= $data['bonusName'] ?></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">贷款期限</label>
                            <?php if (!empty($data['loanRates'])): ?>
                        <select name="term_days" class="form-select" required>
                                    <?php foreach ($data['loanRates'] as $rate): ?>
                                        <option value="<?= $rate['term_days'] ?>"><?= $rate['term_days'] ?>天 (日利率: <?= number_format($rate['loan_rate'] * 100, 2) ?>%)</option>
                            <?php endforeach; ?>
                        </select>
                            <?php else: ?>
                                <div class="form-input" style="background-color: #f8f9fa; color: #6c757d; cursor: not-allowed;">
                                    暂无可选期限，请联系管理员配置
                                </div>
                                <small class="text-muted">管理员需要在后台设置中配置贷款期限和利率</small>
                            <?php endif; ?>
                    </div>
                        <?php if (!empty($data['loanRates'])): ?>
                            <?php if (($data['currentBonus'] ?? 0) < 0): ?>
                                <div class="muted" style="margin-top:6px;">当前<?= $data['bonusName'] ?>为负，暂不可申请贷款</div>
                                <button type="button" class="btn btn-secondary" disabled>暂不可用</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-primary">提交申请</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary" disabled>暂不可用</button>
                        <?php endif; ?>
                </form>
                </div>
            <?php endif; ?>
            <div class="sub-title">贷款说明</div>
            <div class="rate-grid" aria-label="贷款期限与利率">
              <?php if (!empty($data['loanRates'])): ?>
                <?php foreach ($data['loanRates'] as $r): ?>
                  <span class="rate-chip"><?= (int)$r['term_days'] ?> 天 · <?= number_format((float)$r['loan_rate']*100,2) ?>%/日</span>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="text-muted" style="padding: 20px; text-align: center; background-color: #f8f9fa; border-radius: 8px;">
                  <i class="fas fa-info-circle"></i> 暂无可选期限，请联系管理员配置
                </div>
              <?php endif; ?>
            </div>
        </div>
      </div>
      <div>
        <div class="bank-section">
            <div class="section-head"><span class="head-icon">💎</span><div class="head-title">存款服务</div></div>
            <div class="tabs" role="tablist" aria-label="存款操作">
                <button class="tab-btn active" id="tab-fixed" type="button" onclick="showDepositTab('fixed')" role="tab" aria-selected="true">定期存款</button>
                <button class="tab-btn" id="tab-demand-in" type="button" onclick="showDepositTab('demand-in')" role="tab" aria-selected="false">活期存入</button>
                <button class="tab-btn" id="tab-demand-out" type="button" onclick="showDepositTab('demand-out')" role="tab" aria-selected="false">活期支取</button>
            </div>
            <div id="deposit-pane-fixed">
                <form method="post" action="/bank-deposit.php" class="form-row">
                    <input type="hidden" name="deposit_type" value="fixed">
                    <div class="form-field">
                    <label class="form-label">存款金额</label>
                        <input type="number" name="amount" class="form-input" step="0.01" min="<?= $data['minDepositAmount'] ?>" max="<?= $data['currentBonus'] ?>" placeholder="输入存款金额" required>
                    <small>最小: <?= number_format($data['minDepositAmount']) ?> <?= $data['bonusName'] ?>，当前余额: <?= number_format($data['currentBonus']) ?> <?= $data['bonusName'] ?></small>
                </div>
                    <div class="form-field">
                    <label class="form-label">存款期限</label>
                        <?php if (!empty($data['depositRates'])): ?>
                    <select name="term_days" class="form-select" required>
                                <?php foreach ($data['depositRates'] as $rate): ?>
                                    <option value="<?= $rate['term_days'] ?>"><?= $rate['term_days'] ?>天 (日利率: <?= number_format($rate['deposit_rate'] * 100, 2) ?>%)</option>
                        <?php endforeach; ?>
                    </select>
                        <?php else: ?>
                            <div class="form-input" style="background-color: #f8f9fa; color: #6c757d; cursor: not-allowed;">
                                暂无可选期限，请联系管理员配置
                            </div>
                            <small class="text-muted">管理员需要在后台设置中配置定期存款期限和利率</small>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="form-label" style="visibility:hidden;">提交</label>
                        <?php if (!empty($data['depositRates'])): ?>
                            <button type="submit" class="btn btn-success">立即创建</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary" disabled>暂不可用</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div id="deposit-pane-demand-in" class="hidden">
                <form method="post" action="/bank-deposit.php" class="form-row">
                    <input type="hidden" name="deposit_type" value="demand">
                    <input type="hidden" name="term_days" value="0">
                    <div class="form-field">
                        <label class="form-label">存入金额</label>
                        <input type="number" name="amount" class="form-input" step="0.01" min="<?= $data['minDepositAmount'] ?>" max="<?= $data['currentBonus'] ?>" placeholder="输入金额" required>
                        <small>活期日利率：<?= number_format(($data['demandInterestRate'] ?? 0) * 100, 3) ?>%</small>
                    </div>
                    <div>
                        <label class="form-label" style="visibility:hidden;">提交</label>
                        <button type="submit" class="btn btn-success">立即存入</button>
                    </div>
                </form>
            </div>
            <div id="deposit-pane-demand-out" class="hidden">
                <form method="post" action="/bank-withdraw.php" class="form-row">
                    <input type="hidden" name="deposit_id" value="0">
                    <input type="hidden" name="demand_withdraw" value="1">
                    <div class="form-field">
                        <label class="form-label">支取金额</label>
                        <input type="number" name="amount" class="form-input" step="0.01" min="0.01" max="<?= $data['demandAccount']['balance'] ?? 0 ?>" placeholder="输入金额" required>
                    </div>
                    <div>
                        <label class="form-label" style="visibility:hidden;">提交</label>
                        <button type="submit" class="btn btn-warning">立即支取</button>
                    </div>
                </form>
            </div>

            <hr style="border:none; border-top:1px solid #eee; margin:22px 0;" />

            <h3 class="section-title" style="border-bottom:none; padding-bottom:0; margin-bottom:8px;">活期账户</h3>
            <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                <div class="stat-card" style="flex:1; min-width:240px;">
                    <div class="stat-value"><?= number_format($data['demandAccount']['balance'] ?? 0, 2) ?></div>
                    <div class="stat-label">余额（<?= $data['bonusName'] ?>）</div>
                </div>
                <div class="stat-card" style="flex:1; min-width:240px;">
                    <div class="stat-value"><?= number_format(($data['demandInterestRate'] ?? 0) * 100, 2) ?>%</div>
                    <div class="stat-label">活期日利率</div>
                </div>
                <div class="action-bar" style="display:flex;gap:8px;align-items:center;">
                    <button class="btn btn-success" onclick="showDepositTab('demand-in');document.getElementById('tab-demand-in').scrollIntoView({behavior:'smooth',block:'center'})">活期存入</button>
                    <button class="btn btn-warning" onclick="showDepositTab('demand-out');document.getElementById('tab-demand-out').scrollIntoView({behavior:'smooth',block:'center'})">活期支取</button>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="row-spacer"></div>
    <!-- 第三行：定期存款卡片列表 -->
    <?php if (!empty($data['deposits'])): ?>
    <div class="panel">
        <div class="panel-title">我的定期存款（在投 <?= (int)($data['fixedActiveCount'] ?? 0) ?> 笔｜合计 <?= number_format($data['fixedActiveTotal'] ?? 0, 2) ?> <?= $data['bonusName'] ?>）</div>
        <div class="muted" style="margin:-6px 0 14px 0;">定期提前支取将扣除手续费：<?= number_format(($data['penaltyRate'] ?? 0)*100, 2) ?>%（活期不收取）。</div>
        <div class="deposits-container">
            <div class="deposits-grid" id="depositsGrid">
                <?php 
                $deposits = $data['deposits'] ?? [];
                $maxVisible = 3; // 默认显示3个
                $visibleDeposits = array_slice($deposits, 0, $maxVisible);
                $hiddenCount = count($deposits) - $maxVisible;
                ?>
                <?php foreach ($visibleDeposits as $deposit): ?>
                <div class="deposit-card">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div><strong><?= number_format($deposit['amount'], 2) ?> <?= $data['bonusName'] ?></strong></div>
                        <span class="badge"><?= $deposit['term_days'] ?> 天</span>
                    </div>
                    <div class="muted" style="margin-top:6px;">日利率：<?= number_format($deposit['interest_rate'] * 100, 2) ?>% ｜ 到期：<?= $deposit['maturity_date'] ?: '-' ?></div>
                    <div style="margin-top:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                        <?php
                          $status = $deposit['status'];
                          $statusCn = [
                            'active' => '进行中',
                            'paid' => '已结清',
                            'overdue' => '已逾期',
                            'matured' => '已到期',
                            'withdrawn' => '已支取'
                          ][$status] ?? $status;
                        ?>
                        <span class="status-<?= htmlspecialchars($status) ?>" style="font-weight:600;font-size:12px;"><?= htmlspecialchars($statusCn) ?></span>
                        <?php if (($deposit['status']==='active') && ($deposit['type']??'fixed')==='fixed' && isset($deposit['accrued_theoretical'])): ?>
                          <span class="badge-info" style="border-radius:8px;padding:2px 8px;">应计至今：<?= number_format($deposit['accrued_theoretical'],2) ?> <?= $data['bonusName'] ?></span>
                        <?php endif; ?>
                        <?php if ($deposit['status'] === 'active'): ?>
                            <form method="post" action="/bank-withdraw.php" style="margin-left:auto;">
                                <input type="hidden" name="deposit_id" value="<?= $deposit['id'] ?>">
                                <button type="submit" class="btn btn-warning" onclick="return confirm('提前支取将扣除手续费 <?= number_format(($data['penaltyRate'] ?? 0)*100, 2) ?>%，确定要支取吗？') && setLoading(this)">提前支取</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- 隐藏的存款卡片 -->
            <div class="deposits-hidden" id="depositsHidden" style="display: none;">
                <?php foreach (array_slice($deposits, $maxVisible) as $deposit): ?>
                <div class="deposit-card">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div><strong><?= number_format($deposit['amount'], 2) ?> <?= $data['bonusName'] ?></strong></div>
                        <span class="badge"><?= $deposit['term_days'] ?> 天</span>
                    </div>
                    <div class="muted" style="margin-top:6px;">日利率：<?= number_format($deposit['interest_rate'] * 100, 2) ?>% ｜ 到期：<?= $deposit['maturity_date'] ?: '-' ?></div>
                    <div style="margin-top:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                        <?php
                          $status = $deposit['status'];
                          $statusCn = [
                            'active' => '进行中',
                            'paid' => '已结清',
                            'overdue' => '已逾期',
                            'matured' => '已到期',
                            'withdrawn' => '已支取'
                          ][$status] ?? $status;
                        ?>
                        <span class="status-<?= htmlspecialchars($status) ?>" style="font-weight:600;font-size:12px;"><?= htmlspecialchars($statusCn) ?></span>
                        <?php if (($deposit['status']==='active') && ($deposit['type']??'fixed')==='fixed' && isset($deposit['accrued_theoretical'])): ?>
                          <span class="badge-info" style="border-radius:8px;padding:2px 8px;">应计至今：<?= number_format($deposit['accrued_theoretical'],2) ?> <?= $data['bonusName'] ?></span>
                        <?php endif; ?>
                        <?php if ($deposit['status'] === 'active'): ?>
                            <form method="post" action="/bank-withdraw.php" style="margin-left:auto;">
                                <input type="hidden" name="deposit_id" value="<?= $deposit['id'] ?>">
                                <button type="submit" class="btn btn-warning" onclick="return confirm('提前支取将扣除手续费 <?= number_format(($data['penaltyRate'] ?? 0)*100, 2) ?>%，确定要支取吗？') && setLoading(this)">提前支取</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- 展开/收起按钮 -->
            <?php if ($hiddenCount > 0): ?>
            <div class="deposits-toggle" style="text-align: center; margin-top: 16px;">
                <button class="btn btn-secondary" onclick="toggleDeposits()" id="toggleBtn">
                    <span id="toggleText">展开更多 (<?= $hiddenCount ?> 笔)</span>
                    <span id="toggleIcon">▼</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- 贷款历史（折叠，默认显示3条） -->
    <div class="panel" id="loanHistory">
        <div class="panel-title">我的贷款历史</div>
        <?php $loans = $data['loanHistory'] ?? []; if (empty($loans)): ?>
            <div class="text-muted" style="padding: 12px;">暂无贷款记录</div>
        <?php else: ?>
            <?php 
              $maxLoanVisible = 3;
              $visibleLoans = array_slice($loans, 0, $maxLoanVisible);
              $loanHiddenCount = max(0, count($loans) - $maxLoanVisible);
            ?>
            <div class="deposits-grid" id="loanHistoryGrid">
                <?php foreach ($visibleLoans as $hist): ?>
                    <div class="deposit-card">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <div style="font-weight:800;color:#0f172a;">贷款 <?= number_format($hist['amount'],2) ?> <?= $data['bonusName'] ?></div>
                            <?php 
                              $st = $hist['status'] ?? ''; 
                              $mapLbl = ['active'=>'进行中','paid'=>'已结清','overdue'=>'已逾期','defaulted'=>'违约'];
                              $mapCls = ['active'=>'blue','paid'=>'green','overdue'=>'red','defaulted'=>'gray'];
                              $lbl = $mapLbl[$st] ?? $st; $cls = $mapCls[$st] ?? 'gray';
                              $termTxt = isset($hist['term_days']) ? ((int)$hist['term_days']).'天' : '';
                            ?>
                            <span class="pill <?= 'pill-'.$cls ?>"><?= htmlspecialchars($lbl . ($termTxt?(' · '.$termTxt):'')) ?></span>
                        </div>
                        <div class="dep-meta">借款时间：<span class="value-strong"><?= htmlspecialchars($hist['created_at']) ?></span></div>
                        
                        <div class="dep-meta">到期时间：<span class="value-strong"><?= htmlspecialchars($hist['due_date']) ?></span></div>
                        <div class="dep-meta">还款时间：<span class="value-strong"><?= htmlspecialchars($hist['paid_at'] ?? '-') ?></span></div>
                        <div class="dep-meta">当前剩余欠款：<span class="value-rose"><?= number_format($hist['remaining_amount'],2) ?></span> <?= $data['bonusName'] ?></div>
                        <?php if (($hist['status'] ?? '') === 'active'): ?>
                        <div class="dep-meta" style="display:flex;justify-content:space-between;align-items:center;">
                            <span>利息汇总：<span class="value-emerald"><?= number_format((float)($hist['interest_sum'] ?? 0),2) ?></span> <?= $data['bonusName'] ?></span>
                            <button type="button" class="btn btn-primary" onclick="var x=document.getElementById('repay_amount'); if(x){x.scrollIntoView({behavior:'smooth',block:'center'}); x.focus();}">去还款</button>
                        </div>
                        <?php else: ?>
                        <div class="dep-meta">利息汇总：<span class="value-emerald"><?= number_format((float)($hist['interest_sum'] ?? 0),2) ?></span> <?= $data['bonusName'] ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($loanHiddenCount > 0): ?>
            <div class="deposits-hidden" id="loanHistoryHidden" style="display:none;">
                <?php foreach (array_slice($loans, $maxLoanVisible) as $hist): ?>
                    <div class="deposit-card">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <div style="font-weight:800;color:#0f172a;">贷款 <?= number_format($hist['amount'],2) ?> <?= $data['bonusName'] ?></div>
                            <?php 
                              $st = $hist['status'] ?? ''; 
                              $mapLbl = ['active'=>'进行中','paid'=>'已结清','overdue'=>'已逾期','defaulted'=>'违约'];
                              $mapCls = ['active'=>'blue','paid'=>'green','overdue'=>'red','defaulted'=>'gray'];
                              $lbl = $mapLbl[$st] ?? $st; $cls = $mapCls[$st] ?? 'gray';
                              $termTxt = isset($hist['term_days']) ? ((int)$hist['term_days']).'天' : '';
                            ?>
                            <span class="pill <?= 'pill-'.$cls ?>"><?= htmlspecialchars($lbl . ($termTxt?(' · '.$termTxt):'')) ?></span>
                        </div>
                        <div class="dep-meta">借款时间：<span class="value-strong"><?= htmlspecialchars($hist['created_at']) ?></span></div>
                        
                        <div class="dep-meta">到期时间：<span class="value-strong"><?= htmlspecialchars($hist['due_date']) ?></span></div>
                        <div class="dep-meta">还款时间：<span class="value-strong"><?= htmlspecialchars($hist['paid_at'] ?? '-') ?></span></div>
                        <div class="dep-meta">当前剩余欠款：<span class="value-rose"><?= number_format($hist['remaining_amount'],2) ?></span> <?= $data['bonusName'] ?></div>
                        <?php if (($hist['status'] ?? '') === 'active'): ?>
                        <div class="dep-meta" style="display:flex;justify-content:space-between;align-items:center;">
                            <span>利息汇总：<span class="value-emerald"><?= number_format((float)($hist['interest_sum'] ?? 0),2) ?></span> <?= $data['bonusName'] ?></span>
                            <button type="button" class="btn btn-primary" onclick="var x=document.getElementById('repay_amount'); if(x){x.scrollIntoView({behavior:'smooth',block:'center'}); x.focus();}">去还款</button>
                        </div>
                        <?php else: ?>
                        <div class="dep-meta">利息汇总：<span class="value-emerald"><?= number_format((float)($hist['interest_sum'] ?? 0),2) ?></span> <?= $data['bonusName'] ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="deposits-toggle" style="text-align:center; margin-top: 16px;">
                <button class="btn btn-secondary" onclick="toggleLoanHistory()" id="toggleLoanBtn">
                    <span id="toggleLoanText">展开更多 (<?= $loanHiddenCount ?> 笔)</span>
                    <span class="toggle-icon">▾</span>
                </button>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="row-spacer"></div>
    <!-- 第四行：站点概览（单独一行） -->
    <div class="bank-sections">
      <div class="bank-section">
        <h3 class="section-title">🏦 站点银行概览</h3>
        <div class="overview-stats">
          <div class="stat-item">
            <div class="stat-label">活期总额</div>
            <div class="stat-value"><?= number_format($data['siteOverview']['demand_total'] ?? 0, 2) ?></div>
            <div class="stat-hint"><?= (int)($data['siteOverview']['demand_count'] ?? 0) ?> 人</div>
          </div>
          <div class="stat-item">
            <div class="stat-label">定期在投</div>
            <div class="stat-value"><?= number_format($data['siteOverview']['fixed_active_total'] ?? 0, 2) ?></div>
            <div class="stat-hint"><?= (int)($data['siteOverview']['fixed_count'] ?? 0) ?> 笔</div>
          </div>
          <div class="stat-item">
            <div class="stat-label">在贷总额</div>
            <div class="stat-value"><?= number_format($data['siteOverview']['loan_outstanding'] ?? 0, 2) ?></div>
            <div class="stat-hint"><?= (int)($data['siteOverview']['loan_count'] ?? 0) ?> 笔</div>
          </div>
          <div class="stat-item">
            <div class="stat-label">近期利息</div>
            <div class="stat-value"><?= number_format(array_sum(array_column($data['recentInterest'] ?? [], 'amount')), 2) ?></div>
            <div class="stat-hint">总计</div>
          </div>
        </div>
      </div>
    </div>

    <!-- 第五行：使用规则与说明（单独一行） -->
    <div class="bank-sections">
      <div class="bank-section">
        <h3 class="section-title">📘 使用规则与说明</h3>
          
          <!-- 基本规则 -->
          <div class="rules-section">
            <h4 class="rules-title">💡 基本规则</h4>
            <div class="rules-grid">
              <div class="rule-item">
                <div class="rule-label">贷款额度</div>
                <div class="rule-content">
                  <span class="formula">最大额度 = 时魔 × <?= number_format($data['settingsForDisplay']['loan_ratio'] ?? 0, 2) ?> + <?= number_format($data['settingsForDisplay']['loan_ratio_constant'] ?? 0, 2) ?></span>
                </div>
              </div>
              <div class="rule-item">
                <div class="rule-label">贷款限制</div>
                <div class="rule-content">同一时间仅允许一笔进行中的贷款</div>
              </div>
              <div class="rule-item">
                <div class="rule-label">还款方式</div>
                <div class="rule-content">仅支持"一次性结清"，页面支持一键填充应还金额</div>
              </div>
            </div>
          </div>

          <!-- 利率说明 -->
          <div class="rules-section">
            <h4 class="rules-title">💰 利率说明</h4>
            <div class="rate-grid">
              <div class="rate-card">
                <div class="rate-header">活期存款</div>
                <div class="rate-value"><?= number_format(($data['settingsForDisplay']['demand_interest_rate'] ?? 0) * 100, 3) ?>%/日</div>
                <div class="rate-desc">无固定期限，随时存取，不收手续费</div>
              </div>
              <div class="rate-card">
                <div class="rate-header">定期存款</div>
                <div class="rate-value">
                  <?php $fixedRates = $data['settingsForDisplay']['fixed_deposit_rates'] ?? []; if (!empty($fixedRates)): ?>
                    <?php foreach ($fixedRates as $r): ?>
                      <div class="rate-item"><?= (int)($r['term_days'] ?? 0) ?>天: <?= number_format((float)($r['interest_rate'] ?? 0) * 100, 3) ?>%</div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="rate-item">暂未配置</div>
                  <?php endif; ?>
                </div>
                <div class="rate-desc">提前支取手续费: <?= number_format(($data['penaltyRate'] ?? 0)*100, 2) ?>%</div>
              </div>
              <div class="rate-card">
                <div class="rate-header">贷款</div>
                <div class="rate-value">
                  <?php $loanRates = $data['settingsForDisplay']['loan_interest_rates'] ?? []; if (!empty($loanRates)): ?>
                    <?php foreach ($loanRates as $r): ?>
                      <div class="rate-item"><?= (int)($r['term_days'] ?? 0) ?>天: <?= number_format((float)($r['loan_rate'] ?? 0) * 100, 2) ?>%</div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="rate-item">暂未配置</div>
                  <?php endif; ?>
                </div>
                <div class="rate-desc">逾期罚息: <?= number_format(($data['settingsForDisplay']['overdue_penalty_rate'] ?? 0) * 100, 2) ?>%/日</div>
              </div>
            </div>
          </div>

          <!-- 利息去向 -->
          <div class="rules-section">
            <h4 class="rules-title">🔄 利息去向</h4>
            <div class="interest-flow">
              <div class="flow-item">
                <div class="flow-icon">💳</div>
                <div class="flow-text">活期利息 → 活期账户余额</div>
              </div>
              <div class="flow-item">
                <div class="flow-icon">💰</div>
                <div class="flow-text">定期利息 → 用户余额</div>
              </div>
              <div class="flow-item">
                <div class="flow-icon">📈</div>
                <div class="flow-text">贷款利息 → 贷款欠款</div>
              </div>
            </div>
          </div>

          <!-- 重要提示 -->
          <div class="rules-section">
            <h4 class="rules-title">⚠️ 重要提示</h4>
            <div class="tips-list">
              <div class="tip-item">• 定期利息按日结算发放，"应计至今"为参考值，未到结息日部分不额外发放</div>
              <div class="tip-item">• 提前还款结清额 = 当前欠款 + 截至今日应计利息</div>
              <div class="tip-item">• 贷款逾期将产生额外罚息，请及时还款</div>
              <div class="tip-item">• 定期存款提前支取将扣除手续费，请谨慎操作</div>
            </div>
          </div>
      </div>
    </div>
<script>
// 简易折线图渲染（原生 Canvas）
try {
    var data = <?php echo json_encode($data['recentInterest'] ?? []); ?>;
    var canvas = document.getElementById('interestChart');
    if (canvas && data.length) {
        var ctx = canvas.getContext('2d');
        var W = canvas.width, H = canvas.height;
        ctx.clearRect(0,0,W,H);
        var padding = 24;
        var maxY = Math.max.apply(null, data.map(function(p){return p.amount;}));
        if (maxY <= 0) maxY = 1;
        // 轴
        ctx.strokeStyle = '#e5e7eb';
        ctx.beginPath();
        ctx.moveTo(padding, H - padding);
        ctx.lineTo(W - padding, H - padding);
        ctx.moveTo(padding, padding);
        ctx.lineTo(padding, H - padding);
        ctx.stroke();
        // 线
        ctx.strokeStyle = '#0a84ff';
        ctx.lineWidth = 2;
        ctx.beginPath();
        data.forEach(function(p, i){
            var x = padding + (W - 2*padding) * (i/(data.length-1));
            var y = H - padding - (H - 2*padding) * (p.amount/maxY);
            if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
        });
        ctx.stroke();
    }
} catch (e) {}

function toggleDepositType(type){
    var term = document.getElementById('deposit_term');
    var tip = document.getElementById('demand_tip');
    if(type === 'demand'){
        term.disabled = true;
        term.style.opacity = .6;
        tip.style.display = 'block';
    }else{
        term.disabled = false;
        term.style.opacity = 1;
        tip.style.display = 'none';
    }
}

function setLoading(btn){
    if(btn.dataset.loading === '1'){return false;}
    btn.dataset.loading = '1';
    var old = btn.innerHTML;
    btn.dataset.old = old;
    btn.innerHTML = '处理中…';
    btn.style.opacity = .8;
    // 避免某些浏览器禁用提交按钮会阻止提交，延迟禁用
    setTimeout(function(){ try{ btn.disabled = true; }catch(e){} }, 50);
    return true;
}

function toggleDeposits(){
    var hidden = document.getElementById('depositsHidden');
    var btn = document.getElementById('toggleBtn');
    var text = document.getElementById('toggleText');
    var icon = document.getElementById('toggleIcon');
    
    if(hidden.style.display === 'none'){
        hidden.style.display = 'grid';
        text.textContent = '收起';
        icon.textContent = '▲';
        btn.classList.add('expanded');
    } else {
        hidden.style.display = 'none';
        text.textContent = text.textContent.replace('收起', '展开更多');
        icon.textContent = '▼';
        btn.classList.remove('expanded');
    }
}

// 简单模态框控制
function openModal(id){
  var el = document.getElementById(id);
  if(el){el.classList.add('show');}
}
function closeModal(id){
  var el = document.getElementById(id);
  if(el){el.classList.remove('show');}
}

// 选项卡切换
function showDepositTab(key){
  var panes = {
    'fixed': 'deposit-pane-fixed',
    'demand-in': 'deposit-pane-demand-in',
    'demand-out': 'deposit-pane-demand-out'
  };
  Object.values(panes).forEach(function(id){
    var el = document.getElementById(id); if(el){el.classList.add('hidden');}
  });
  var target = document.getElementById(panes[key]); if(target){target.classList.remove('hidden');}
  // 激活标签
  ['tab-fixed','tab-demand-in','tab-demand-out'].forEach(function(id){
    var el = document.getElementById(id); if(el){el.classList.remove('active');}
  });
  var map = {'fixed':'tab-fixed','demand-in':'tab-demand-in','demand-out':'tab-demand-out'};
  var tab = document.getElementById(map[key]); if(tab){tab.classList.add('active');}
  // 选项卡内容变化后，重新等高
  equalizeRow2();
}
function showLoanTab(key){
  // 目前只有一个面板，占位保留
}

function toggleLoanHistory(){
  var hidden = document.getElementById('loanHistoryHidden');
  var btn = document.getElementById('toggleLoanBtn');
  var text = document.getElementById('toggleLoanText');
  if(!hidden || !btn || !text){return;}
  if(hidden.style.display === 'none'){
    hidden.style.display = 'grid';
    btn.classList.add('expanded');
    text.textContent = '收起';
  } else {
    hidden.style.display = 'none';
    btn.classList.remove('expanded');
    var count = hidden.querySelectorAll('.deposit-card').length;
    text.textContent = '展开更多 ('+count+' 笔)';
  }
}

// 第二行两列等高（不影响布局流）
function equalizeRow2(){
  try{
    var row = document.querySelector('.row-2');
    if(!row) return;
    var cards = row.querySelectorAll('.bank-section');
    if(cards.length !== 2) return;
    // 先清除再测量
    cards.forEach(function(c){ c.style.minHeight = ''; });
    var max = 0;
    cards.forEach(function(c){ max = Math.max(max, c.offsetHeight); });
    cards.forEach(function(c){ c.style.minHeight = max + 'px'; });
  }catch(e){}
}
function debounce(fn, delay){var t; return function(){clearTimeout(t); t=setTimeout(fn, delay);} }
window.addEventListener('load', equalizeRow2);
window.addEventListener('resize', debounce(equalizeRow2, 120));
</script>
</div>

<!-- 模态框：申请贷款 -->
<div class="modal" id="modal-loan-apply" onclick="if(event.target===this)closeModal('modal-loan-apply')">
  <div class="modal-card">
    <div class="modal-header"><strong>申请贷款</strong><button class="close" onclick="closeModal('modal-loan-apply')">✕</button></div>
    <form method="post" action="/bank-loan.php">
      <div class="form-group">
        <label class="form-label">贷款金额</label>
        <input type="number" name="amount" class="form-input" step="0.01" min="<?= $data['minLoanAmount'] ?>" max="<?= $data['maxLoanAmount'] ?>" placeholder="输入贷款金额" required>
        <small>最小: <?= number_format($data['minLoanAmount']) ?> <?= $data['bonusName'] ?>，最大: <?= number_format($data['maxLoanAmount']) ?> <?= $data['bonusName'] ?></small>
      </div>
      <div class="form-group">
        <label class="form-label">贷款期限</label>
        <select name="term_days" class="form-select" required>
          <?php foreach ($data['loanRates'] as $rate): ?>
            <option value="<?= $rate['term_days'] ?>"><?= $rate['term_days'] ?>天 (日利率: <?= number_format($rate['loan_rate'] * 100, 2) ?>%)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="action-bar" style="justify-content:flex-end;">
        <button type="button" class="btn" onclick="closeModal('modal-loan-apply')">取消</button>
        <button type="submit" class="btn btn-primary" onclick="return setLoading(this)">提交申请</button>
      </div>
    </form>
  </div>
  </div>

<!-- 模态框：贷款还款 -->
<div class="modal" id="modal-loan-repay" onclick="if(event.target===this)closeModal('modal-loan-repay')">
  <div class="modal-card">
    <div class="modal-header"><strong>贷款还款</strong><button class="close" onclick="closeModal('modal-loan-repay')">✕</button></div>
    <form method="post" action="/bank-repay.php">
      <div class="form-group">
        <label class="form-label">还款金额</label>
        <input type="number" name="amount" class="form-input" step="0.01" min="0.01" max="<?= $data['currentBonus'] ?>" placeholder="输入还款金额" required>
      </div>
      <div class="action-bar" style="justify-content:flex-end;">
        <button type="button" class="btn" onclick="closeModal('modal-loan-repay')">取消</button>
        <button type="submit" class="btn btn-success" onclick="return setLoading(this)">立即还款</button>
      </div>
    </form>
  </div>
  </div>

<!-- 模态框：定期存款 -->
<div class="modal" id="modal-deposit-fixed" onclick="if(event.target===this)closeModal('modal-deposit-fixed')">
  <div class="modal-card">
    <div class="modal-header"><strong>创建定期存款</strong><button class="close" onclick="closeModal('modal-deposit-fixed')">✕</button></div>
    <form method="post" action="/bank-deposit.php">
      <input type="hidden" name="deposit_type" value="fixed">
      <div class="form-group">
        <label class="form-label">存款金额</label>
        <input type="number" name="amount" class="form-input" step="0.01" min="<?= $data['minDepositAmount'] ?>" max="<?= $data['currentBonus'] ?>" placeholder="输入存款金额" required>
      </div>
      <div class="form-group">
        <label class="form-label">存款期限</label>
        <select name="term_days" class="form-select" required>
          <?php foreach ($data['depositRates'] as $rate): ?>
            <option value="<?= $rate['term_days'] ?>"><?= $rate['term_days'] ?>天 (日利率: <?= number_format($rate['deposit_rate'] * 100, 2) ?>%)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="action-bar" style="justify-content:flex-end;">
        <button type="button" class="btn" onclick="closeModal('modal-deposit-fixed')">取消</button>
        <button type="submit" class="btn btn-success" onclick="return setLoading(this)">立即创建</button>
      </div>
    </form>
  </div>
  </div>

<!-- 模态框：活期存入 -->
<div class="modal" id="modal-deposit-demand" onclick="if(event.target===this)closeModal('modal-deposit-demand')">
  <div class="modal-card">
    <div class="modal-header"><strong>活期存入</strong><button class="close" onclick="closeModal('modal-deposit-demand')">✕</button></div>
    <form method="post" action="/bank-deposit.php">
      <input type="hidden" name="deposit_type" value="demand">
      <input type="hidden" name="term_days" value="0">
      <div class="form-group">
        <label class="form-label">金额</label>
        <input type="number" name="amount" class="form-input" step="0.01" min="<?= $data['minDepositAmount'] ?>" max="<?= $data['currentBonus'] ?>" placeholder="输入金额" required>
        <small>活期日利率：<?= number_format(($data['demandInterestRate'] ?? 0) * 100, 3) ?>%</small>
      </div>
      <div class="action-bar" style="justify-content:flex-end;">
        <button type="button" class="btn" onclick="closeModal('modal-deposit-demand')">取消</button>
        <button type="submit" class="btn btn-success" onclick="return setLoading(this)">立即存入</button>
      </div>
    </form>
  </div>
  </div>

<!-- 模态框：活期支取 -->
<div class="modal" id="modal-demand-withdraw" onclick="if(event.target===this)closeModal('modal-demand-withdraw')">
  <div class="modal-card">
    <div class="modal-header"><strong>活期支取</strong><button class="close" onclick="closeModal('modal-demand-withdraw')">✕</button></div>
    <form method="post" action="/bank-withdraw.php">
      <input type="hidden" name="deposit_id" value="0">
      <input type="hidden" name="demand_withdraw" value="1">
      <div class="form-group">
        <label class="form-label">金额</label>
        <input type="number" name="amount" class="form-input" step="0.01" min="0.01" max="<?= $data['demandAccount']['balance'] ?? 0 ?>" placeholder="输入金额" required>
      </div>
      <div class="action-bar" style="justify-content:flex-end;">
        <button type="button" class="btn" onclick="closeModal('modal-demand-withdraw')">取消</button>
        <button type="submit" class="btn btn-warning" onclick="return setLoading(this)">立即支取</button>
      </div>
    </form>
  </div>
</div>
