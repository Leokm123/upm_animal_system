\# UPM Animal System - 数据库设置指南



\## 团队协作 - 数据库同步



\### 1. 创建本地数据库

在phpMyAdmin或MySQL命令行中创建数据库：

```sql

CREATE DATABASE upm\_animal\_system CHARACTER SET utf8mb4 COLLATE utf8mb4\_unicode\_ci;

```



\### 2. 配置环境文件

```bash

\# 复制环境配置文件

cp . env.example .env

```



编辑 `.env` 文件，设置数据库连接：

```env

DB\_CONNECTION=mysql

DB\_HOST=127.0.0.1

DB\_PORT=3306

DB\_DATABASE=upm\_animal\_system

DB\_USERNAME=root

DB\_PASSWORD=你的MySQL密码（XAMPP默认为空）

```



\### 3. 安装项目依赖

```bash

composer install

php artisan key:generate

```



\### 4. 导入数据库数据



\*\*方式A:  使用phpMyAdmin（推荐新手）\*\*

1\. 打开浏览器访问 `http://localhost/phpmyadmin`

2\. 点击左侧的 `upm\_animal\_system` 数据库

3\. 点击顶部的"导入"标签

4\. 点击"选择文件"，选择项目中的 `database/sql/initial\_data.sql`

5\. 滚动到底部，点击"执行"按钮

6\. 看到"导入已成功完成"提示即可



\*\*方式B: 使用命令行\*\*

```bash

\# 在XAMPP的mysql/bin目录下执行

mysql -u root -p upm\_animal\_system < database/sql/initial\_data.sql

```



\### 5. 验证导入成功

```bash

\# 检查数据库连接

php artisan tinker

\# 在tinker中执行：

>>> \\App\\Models\\User::count()

>>> \\DB::table('animals')->count()

\# 如果返回数字而不是错误，说明导入成功



\# 启动开发服务器

php artisan serve

```



\## 数据库内容说明

\- \*\*animals\*\* - 动物信息表

\- \*\*sightings\*\* - 目击记录表  

\- \*\*users\*\* - 用户表

\- \*\*volunteers\*\* - 志愿者表

\- 其他Laravel系统表



\## 开发注意事项

\- 导入SQL文件后，无需运行 `php artisan migrate`

\- 数据库文件包含完整的表结构和现有数据

\- 如需修改数据库结构，请创建新的迁移文件

\- 重要数据更新时，重新导出并更新此SQL文件



\## 故障排除

\- \*\*导入失败\*\*:  检查MySQL服务是否启动，数据库是否正确创建

\- \*\*连接失败\*\*: 检查`.env`文件中的数据库配置

\- \*\*权限错误\*\*: 确保MySQL用户有足够权限操作数据库

