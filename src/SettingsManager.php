<?php

namespace NexusPlugin\BankSystem;

use Filament\Forms;
use Filament\Forms\Form;

class SettingsManager
{
    /**
     * 获取设置标签页结构
     */
    public static function getSettingTab(): \Filament\Forms\Components\Tabs\Tab
    {
        return \Filament\Forms\Components\Tabs\Tab::make('银行系统')
            ->id('bank_system_settings')
            ->schema(self::getSettingSchema())
            ->columns(2);
    }

    public static function form(Form $form): Form
    {
        return $form->schema(self::getSettingSchema());
    }

    /**
     * 获取设置表单结构
     */
    protected static function getSettingSchema(): array
    {
        return [
            Forms\Components\Section::make('基本设置')
                ->schema([
                    Forms\Components\Toggle::make('bank_system.enabled')
                        ->label('启用银行系统')
                        ->default(true)
                        ->helperText('是否启用银行系统功能'),

                    Forms\Components\Toggle::make('bank_system.show_in_navigation')
                        ->label('显示在导航栏')
                        ->default(true)
                        ->helperText('是否在站点导航栏中显示银行菜单'),

                    Forms\Components\Select::make('bank_system.min_user_class')
                        ->label('最低用户等级')
                        ->options(self::getUserClassOptions())
                        ->default(\App\Models\User::CLASS_USER)
                        ->helperText('允许使用银行系统的最低用户等级'),
                ])
                ->columns(2),

            Forms\Components\Section::make('贷款设置')
                ->schema([
                    Forms\Components\TextInput::make('bank_system.loan_ratio')
                        ->label('贷款系数')
                        ->numeric()
                        ->default(100)
                        ->helperText('最大贷款额度 = 时魔 × 贷款系数')
                        ->suffix(function () {
                            return nexus_trans('user.labels.seedbonus') ?: '魔力';
                        }),

                    Forms\Components\TextInput::make('bank_system.loan_interest_rate')
                        ->label('贷款日利率 (%)')
                        ->numeric()
                        ->step(0.01)
                        ->default(0.1)
                        ->helperText('贷款的日利率百分比'),

                    Forms\Components\Repeater::make('bank_system.loan_interest_rates')
                        ->label('贷款分级利率')
                        ->schema([
                            Forms\Components\TextInput::make('term_days')
                                ->label('期限（天）')
                                ->numeric()
                                ->required()
                                ->minValue(1),
                            Forms\Components\TextInput::make('name')
                                ->label('显示名称')
                                ->required()
                                ->placeholder('如：7天、15天'),
                            Forms\Components\TextInput::make('loan_rate')
                                ->label('日利率 (%)')
                                ->numeric()
                                ->step(0.001)
                                ->required()
                                ->minValue(0),
                        ])
                        ->default([
                            ['term_days' => 7, 'name' => '7天', 'loan_rate' => 0.08],
                            ['term_days' => 15, 'name' => '15天', 'loan_rate' => 0.10],
                            ['term_days' => 30, 'name' => '30天', 'loan_rate' => 0.12],
                            ['term_days' => 60, 'name' => '60天', 'loan_rate' => 0.15],
                            ['term_days' => 90, 'name' => '90天', 'loan_rate' => 0.18],
                        ])
                        ->helperText('不同期限的贷款利率，期限和利率完全可自定义')
                        ->columns(3)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('bank_system.min_loan_amount')
                        ->label('最小贷款金额')
                        ->numeric()
                        ->default(100)
                        ->helperText('允许申请的最小贷款金额')
                        ->suffix(function () {
                            return nexus_trans('user.labels.seedbonus') ?: '魔力';
                        }),
                ])
                ->columns(2),

            Forms\Components\Section::make('活期存款设置')
                ->schema([
                    Forms\Components\TextInput::make('bank_system.demand_interest_rate')
                        ->label('活期存款日利率 (%)')
                        ->numeric()
                        ->step(0.001)
                        ->default(0.01)
                        ->helperText('活期存款的日利率，可随时存取'),

                    Forms\Components\TextInput::make('bank_system.min_demand_amount')
                        ->label('最小活期存款金额')
                        ->numeric()
                        ->default(100)
                        ->helperText('活期存款的最小金额')
                        ->suffix(function () {
                            return nexus_trans('user.labels.seedbonus') ?: '魔力';
                        }),
                ])
                ->columns(2),

            Forms\Components\Section::make('定期存款设置')
                ->schema([
                    Forms\Components\TextInput::make('bank_system.min_fixed_amount')
                        ->label('最小定期存款金额')
                        ->numeric()
                        ->default(1000)
                        ->helperText('定期存款的最小金额')
                        ->suffix(function () {
                            return nexus_trans('user.labels.seedbonus') ?: '魔力';
                        }),

                    Forms\Components\TextInput::make('bank_system.max_fixed_amount')
                        ->label('最大定期存款金额')
                        ->numeric()
                        ->default(100000)
                        ->helperText('单笔定期存款的最大金额，0表示无限制')
                        ->suffix(function () {
                            return nexus_trans('user.labels.seedbonus') ?: '魔力';
                        }),

                    Forms\Components\TextInput::make('bank_system.early_withdrawal_penalty')
                        ->label('提前支取手续费率 (%)')
                        ->numeric()
                        ->step(0.1)
                        ->default(1.0)
                        ->helperText('提前支取定期存款的手续费率'),

                    Forms\Components\Repeater::make('bank_system.fixed_deposit_rates')
                        ->label('定期存款分级利率')
                        ->schema([
                            Forms\Components\TextInput::make('term_days')
                                ->label('期限（天）')
                                ->numeric()
                                ->required()
                                ->minValue(1),
                            Forms\Components\TextInput::make('name')
                                ->label('显示名称')
                                ->required()
                                ->placeholder('如：30天、60天'),
                            Forms\Components\TextInput::make('interest_rate')
                                ->label('日利率 (%)')
                                ->numeric()
                                ->step(0.001)
                                ->required()
                                ->minValue(0),
                        ])
                        ->default([
                            ['term_days' => 30, 'name' => '30天', 'interest_rate' => 0.05],
                            ['term_days' => 60, 'name' => '60天', 'interest_rate' => 0.08],
                            ['term_days' => 90, 'name' => '90天', 'interest_rate' => 0.12],
                            ['term_days' => 180, 'name' => '180天', 'interest_rate' => 0.18],
                            ['term_days' => 360, 'name' => '360天', 'interest_rate' => 0.25],
                        ])
                        ->helperText('不同期限的定期存款利率，期限和利率完全可自定义')
                        ->columns(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('风控设置')
                ->schema([
                    Forms\Components\TextInput::make('bank_system.overdue_penalty_rate')
                        ->label('逾期罚息率 (%)')
                        ->numeric()
                        ->step(0.01)
                        ->default(0.5)
                        ->helperText('贷款逾期后的额外日罚息率'),

                    Forms\Components\TextInput::make('bank_system.auto_deduct_days')
                        ->label('自动扣款天数')
                        ->numeric()
                        ->default(7)
                        ->helperText('逾期多少天后自动从用户魔力中扣款'),
                ])
                ->columns(2),
        ];
    }

    /**
     * 获取用户等级选项
     */
    protected static function getUserClassOptions(): array
    {
        try {
            return \App\Models\User::listClass(\App\Models\User::CLASS_USER, \App\Models\User::CLASS_NEXUS_MASTER);
        } catch (\Exception $e) {
            // 如果获取失败，返回默认选项
            return [
                \App\Models\User::CLASS_USER => 'User',
                \App\Models\User::CLASS_POWER_USER => 'Power User',
                \App\Models\User::CLASS_ELITE_USER => 'Elite User',
                \App\Models\User::CLASS_CRAZY_USER => 'Crazy User',
                \App\Models\User::CLASS_INSANE_USER => 'Insane User',
                \App\Models\User::CLASS_VETERAN_USER => 'Veteran User',
                \App\Models\User::CLASS_EXTREME_USER => 'Extreme User',
                \App\Models\User::CLASS_ULTIMATE_USER => 'Ultimate User',
                \App\Models\User::CLASS_NEXUS_MASTER => 'Nexus Master',
            ];
        }
    }

    /**
     * 获取默认设置
     */
    public static function getDefaultSettings(): array
    {
        return [
            'enabled' => true,
            'show_in_navigation' => true,
            'min_user_class' => \App\Models\User::CLASS_USER,
            'loan_ratio' => 100,
            'loan_interest_rate' => 0.1,
            'loan_interest_rates' => [
                ['term_days' => 7, 'name' => '7天', 'loan_rate' => 0.08],
                ['term_days' => 15, 'name' => '15天', 'loan_rate' => 0.10],
                ['term_days' => 30, 'name' => '30天', 'loan_rate' => 0.12],
                ['term_days' => 60, 'name' => '60天', 'loan_rate' => 0.15],
                ['term_days' => 90, 'name' => '90天', 'loan_rate' => 0.18],
            ],
            'min_loan_amount' => 100,
            'demand_interest_rate' => 0.01,
            'min_demand_amount' => 100,
            'min_fixed_amount' => 1000,
            'max_fixed_amount' => 100000,
            'early_withdrawal_penalty' => 1.0,
            'fixed_deposit_rates' => [
                ['term_days' => 30, 'name' => '30天', 'interest_rate' => 0.05],
                ['term_days' => 60, 'name' => '60天', 'interest_rate' => 0.08],
                ['term_days' => 90, 'name' => '90天', 'interest_rate' => 0.12],
                ['term_days' => 180, 'name' => '180天', 'interest_rate' => 0.18],
                ['term_days' => 360, 'name' => '360天', 'interest_rate' => 0.25],
            ],
            'overdue_penalty_rate' => 0.5,
            'auto_deduct_days' => 7,
        ];
    }
}
