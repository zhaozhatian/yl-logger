# yl-logger/async-logger

## 项目概述
`yl-logger/async-logger` 是一款专为 Laravel 应用打造的异步日志记录解决方案。它基于 RabbitMQ 实现日志处理的异步化，搭配 MongoDB 进行高效存储，有效解决同步日志写入导致的请求响应延迟问题。无论是高并发场景下的日志记录，还是精细化的日志管理需求，本工具包都能提供强大且灵活的支持，助力开发者更专注于核心业务逻辑开发。

## 核心特性
- **异步高效处理**：借助 RabbitMQ 消息队列，将日志记录操作从主线程剥离，实现非阻塞式写入，显著提升应用响应性能。
- **海量数据存储**：采用 MongoDB 作为日志存储后端，支持高吞吐量写入和快速查询，轻松应对大规模日志数据场景。
- **深度框架集成**：无缝对接 Laravel 生态，提供简洁统一的 API 接口和服务提供者，大幅降低接入成本。
- **灵活扩展能力**：支持自定义日志处理逻辑与存储策略，适配不同项目的差异化需求。

## 运行环境
- **PHP 版本**：^8.1
- **Laravel 版本**：^11.0
- **依赖扩展**：
    - `vladimir-yuldashev/laravel-queue-rabbitmq`（RabbitMQ 队列支持）
    - `mongodb/laravel-mongodb`（MongoDB 存储支持）

## 安装指南
### 1. 通过 Composer 安装
在项目根目录执行以下命令：
```bash  
composer require yl-logger/async-logger  
```
### 2. 配置 Laravel
在queues.php中添加以下配置：
```
'connections' => [  
    'rabbitmq' => [  
        'driver' => 'rabbitmq',  
        'hosts' => ['127.0.0.1'],  
        'port' => 5672,  
        'user' => 'guest',  
        'password' => 'guest',  
        'vhost' => '/',  
        'queue' => 'default',  
        'exchange' => '',  
        'exchange_type' => 'direct',  
        'heartbeat' => 30,  
        'blocked_connection_timeout' => 300,  
    ],  
],  
```
在config/database.php中添加以下配置：
```
'mongodb' => [  
    'driver' =>'mongodb',  
    'host' => env('DB_HOST', 'localhost'),  
    'port' => env('DB_PORT', 27017),  
    'database' => env('DB_DATABASE', 'laravel'),  
    'username' => env('DB_USERNAME', 'root'),  
    'password' => env('DB_PASSWORD', ''),  
    'options' => [  
        'database' => 'admin',  
        'typeMap' => [  
            'root' => 'array',  
            'document' => 'array',  
            'array' => 'array',  
        ],  
    ],  
],  
```
### 3. 配置日志记录器
在.env文件中添加以下配置：
```
ASYNC_LOGGER_QUEUE=async-logger（日志队列名称）
```
### 4. 发布配置
执行以下命令发布配置：
```
php artisan vendor:publish --provider="yl_logger\AsyncLogger\AsyncLoggerServiceProvider"
```
### 5. 启动队列消费者
执行以下命令启动队列消费者：(需要安装 RabbitMQ 并启动服务)
```
php artisan queue:work 
```
### 6. 使用案例

```
<?php  

namespace App\Http\Controllers;  

use YlLogger\AsyncLogger\Facades\AsyncLogger;  
use Illuminate\Http\Request;  

class ExampleController extends Controller  
{  
    public function index(Request $request)  
    {  
        try {  
            // 业务逻辑执行  
            $result = someComplexOperation();  

            // 记录成功日志，支持携带上下文数据  
            AsyncLogger::info('Operation successful', ['result' => $result]);  

            return response()->json(['message' => 'Success']);  
        } catch (\Exception $e) {  
            // 记录错误日志，自动捕获异常信息  
            AsyncLogger::error('Operation failed', ['error' => $e->getMessage()]);  

            return response()->json(['message' => 'Error'], 500);  
        }  
    }  
}  
```
