# NexusPHP 银行系统插件

一个功能完整的银行系统插件，为 NexusPHP 提供存款、贷款、利息管理等核心金融功能。

## 功能特性

### 💰 存款服务
- **活期存款**：无固定期限，随时存取，按日计息
- **定期存款**：固定期限，不同期限享受不同利率
- **自动计息**：每日自动计算并发放利息
- **提前支取**：支持提前支取（定期需扣除手续费）

### 🏦 贷款服务
- **灵活额度**：贷款额度 = 时魔 × 系数 + 常数（可配置）
- **分档利率**：不同期限享受不同贷款利率
- **自动计息**：每日自动计算贷款利息
- **提前还款**：支持一次性结清（本金+应计利息）

### 📊 管理功能
- **实时统计**：用户资产概览、站点银行数据
- **利息记录**：完整的利息发放记录
- **到期提醒**：存款到期、贷款逾期提醒
- **自动处理**：逾期贷款自动扣款、到期存款自动返还

### 🎨 用户界面
- **现代设计**：简洁美观
- **响应式布局**：完美适配桌面和移动设备
- **实时数据**：动态显示应计利息、到期信息
- **友好提示**：清晰的操作说明和规则展示

## 安装指南

### 1. 下载插件

将插件下载到站点根目录的 `packages` 文件夹：

```bash
# 创建 packages 目录（如果不存在）
mkdir -p packages

# 将下载的插件解压到 packages 目录
# 确保目录结构为：packages/nexusphp-bank-system/
```

### 2. 修改 Composer 配置

在站点根目录的 `composer.json` 中添加：

```json
{
    "repositories": {
        "bank-system": {
            "type": "path",
            "url": "./packages/nexusphp-bank-system"
        }
    },
    "require": {
        "madrays/nexusphp-bank-system": "dev-main"
    }
}
```

### 3. 安装插件

```bash
# 重新生成自动加载文件
composer dump-autoload

# 安装插件
composer require madrays/nexusphp-bank-system

# 执行插件安装
php artisan plugin install madrays/nexusphp-bank-system
```

### 4. 运行数据库迁移

```bash
# 创建银行系统表
php artisan migrate --path=packages/nexusphp-bank-system/database/migrations/2024_01_01_000001_create_bank_tables.php --force

# 添加活期账户和存款类型
php artisan migrate --path=packages/nexusphp-bank-system/database/migrations/2024_01_01_000002_add_demand_accounts_and_deposit_type.php --force

# 扩展利息记录类型
php artisan migrate --path=packages/nexusphp-bank-system/database/migrations/2024_01_01_000003_alter_interest_records_add_demand.php --force
```

### 5. 设置定时任务

```bash
cd packages/nexusphp-bank-system

# 安装定时任务（每小时第5分钟执行）
./setup-cron.sh install --minute 5 --site-root /path/to/your/site

# 验证定时任务
./setup-cron.sh verify --site-root /path/to/your/site
```

### 6. 清除缓存

```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

## 配置说明

### 后台设置

进入 **设置 > 银行系统** 进行配置：

- **启用银行系统**：开启/关闭银行功能
- **活期日利率**：活期存款的日利率（小数形式，如 0.01 = 1%）
- **定期利率分档**：不同期限的定期存款利率
- **贷款利率分档**：不同期限的贷款利率
- **贷款额度系数**：时魔 × 系数 + 常数
- **最小金额限制**：存款/贷款的最小金额
- **提前支取手续费**：定期存款提前支取的手续费比例

### 定时任务

系统每小时自动执行以下任务：

1. **活期计息**：将利息计入活期账户余额
2. **定期计息**：将利息发放到用户余额
3. **贷款计息**：将利息计入贷款欠款
4. **到期处理**：处理到期的存款和逾期的贷款
5. **自动扣款**：对严重逾期的贷款执行自动扣款

## 使用说明

### 用户操作

1. **访问银行**：点击导航菜单中的"银行系统"
2. **查看资产**：在概览页面查看个人资产状况
3. **存款操作**：
   - 活期：随时存取，无手续费
   - 定期：选择期限，享受更高利率
4. **贷款操作**：
   - 申请贷款：选择金额和期限
   - 提前还款：一次性结清本金+利息

### 管理员操作

1. **系统设置**：在后台配置各项参数
2. **数据监控**：查看银行系统运行状况
3. **日志查看**：监控定时任务执行情况

## 技术规格

- **PHP版本**：8.0+
- **数据库**：MySQL 5.7+
- **框架**：NexusPHP 1.7.21+
- **前端**：原生HTML/CSS/JavaScript
- **定时任务**：Cron（推荐每小时执行）

## 文件结构

```
nexusphp-bank-system/
├── src/                          # 核心业务逻辑
│   ├── BankSystemRepository.php  # 数据访问层
│   ├── BankScheduler.php         # 定时任务处理
│   ├── BankController.php        # 控制器
│   └── SettingsManager.php       # 设置管理
├── database/migrations/          # 数据库迁移
├── resources/views/              # 视图模板
├── public/                       # 公共文件
├── run-bank-scheduler.sh         # 定时任务脚本
├── setup-cron.sh                 # 定时任务安装工具
└── test-scheduler.sh             # 测试工具
```

## 故障排除

### 定时任务未执行

```bash
# 检查定时任务状态
./setup-cron.sh show

# 手动测试执行
./test-scheduler.sh --site-root /path/to/site --debug

# 查看日志
tail -n 50 logs/bank_scheduler.log
```

### 数据库问题

```bash
# 检查表是否存在
SHOW TABLES LIKE 'bank_%';

# 检查利息记录
SELECT * FROM bank_interest_records WHERE calculation_date = CURDATE();
```

## 更新日志

### v1.0.0
- 初始版本发布
- 完整的存款/贷款功能
- 自动计息和到期处理
- 现代用户界面
- 定时任务管理工具

## 许可证

MIT License - 详见 [LICENSE](LICENSE) 文件

## 支持

如有问题或建议，请提交 Issue 或联系开发者。