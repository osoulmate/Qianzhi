# 千知博客

#### 介绍
原生PHP MVC架构开发的个人博客，项目受到作者Anant Garg 的文章
[Write your own PHP MVC Framework (Part 1)](https://anantgarg.com/p/write-your-own-php-mvc-framework-part-1)
[Write your own PHP MVC Framework (Part 2)](https://anantgarg.com/p/write-your-own-php-mvc-framework-part-2)启发

#### 软件架构
MVC

#### 系统环境
PHP 7.4

MySQL 7.5

Apache/2.4.6 
#### 安装

##### centos7-X86_64
###### 安装http,php-fpm,mysql服务
```
yum install -y epel-release 
yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm
yum install -y httpd mod_ssl php73-php-fpm php73-php-cli php73-php-bcmath \
    php73-php-gd php73-php-json php73-php-mbstring php73-php-mcrypt \
    php73-php-mysqlnd php73-php-opcache php73-php-pdo php73-php-pecl-crypto\
    php73-php-pecl-mcrypt php73-php-pecl-geoip php73-php-recode php73-php-snmp\
    php73-php-soap php73-php-xmll
curl -L http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm \
     -o mysql-community-release-el7-5.noarch.rpm
rpm -ivh mysql-community-release-el7-5.noarch.rpm
yum install -y mysql-community-server
```
###### 配置http服务，以支持.htaccess伪静态功能
```
sed -i "s/AllowOverride None/AllowOverride All/g" /etc/httpd/conf/httpd.conf
sed -i "s/DirectoryIndex index.html/DirectoryIndex index.php index.html/g" /etc/httpd/conf/httpd.conf
cat >> /etc/httpd/conf/httpd.conf <<EOF
<FilesMatch \.php$>
         SetHandler "proxy:fcgi://127.0.0.1:9000"
</FilesMatch>
#RewriteEngine on
#RewriteCond %{SERVER_PORT} !^443$
#RewriteRule ^/?(.*)$ https://%{SERVER_NAME}/$1 [L,R]
EOF
```
###### 配置mysql
```
sed -i '/datadir/adefault-storage-engine=INNODB'  /etc/my.cnf
sed -i '/datadir/acharacter-set-server=utf8'  /etc/my.cnf
sed -i '/datadir/acollation-server=utf8_general_ci'  /etc/my.cnf
sed -i 's/^datadir/#datadir/' /etc/my.cnf
sed -i '/datadir/adatadir=\/data\/mysql/' /etc/my.cnf
# 添加mysql配置
cat >> /etc/my.cnf <<EOF
[client]
default-character-set = utf8
EOF
mkdir -p /data/mysql 
chown mysql:mysql /data/mysql
service mysqld start
mysql -e "create database qianzhi_db;"
mysql -e "set password for 'root'@'localhost'=password('yourpassword');"

```
###### 下载源码并拷贝至默认网站目录
```
cd /var/www/html
git clone https://github.com/osoulmate/Qianzhi.git 
cp -ra Qianzhi/* /var/www/html/
chown -R apache:apache /var/www/html/tmp
chown -R apache:apache /var/www/html/db
chown -R root:apache /var/www/html/session
chmod -R 775 /var/www/html/tmp
chmod -R 775 /var/www/html/session
```
###### 选择数据库，导入sql
```
mysql> use qianzhi_db;
mysql> source /root/Qianzhi/db/qianzhi.sql;
```
###### HTTPS配置
*免费证书申请*
1. 下载acme.sh
```
cd ~
git clone https://gitee.com/osoulmate/acme.sh.git
```
2. 安装配置acme.sh
```
cd acme.sh
./acme.sh --install -m askqingya@163.com
source /root/.bashrc
```
3. 申请证书

方法1：
```
acme.sh --issue --apache -d zhangqingya.cn
```
 方法2：
```
export Ali_Key="youralikey"
export Ali_Secret="youralisecret"
acme.sh --issue --dns dns_ali --log -d zhangqingya.cn -d *.zhangqingya.cn
```
4. 安装证书(*注意：以下证书路径来源于上步输出，请依据实际进行修改*)

```
acme.sh  --installcert  -d  zhangqingya.cn   \
        --cert-file  /etc/httpd/conf/ssl/6547720_zhangqingya.cn_public.crt  \
        --key-file   /etc/httpd/conf/ssl/6547720_zhangqingya.cn.key \
        --fullchain-file /etc/httpd/conf/ssl/6547720_zhangqingya.cn_chain.crt \
        --reloadcmd  "systemctl reload httpd"
```
5. 编辑/etc/httpd/conf.d/ssl.conf文件，修改证书、公钥及证书链路径
```
SSLCertificateFile /etc/httpd/conf/ssl/6547720_zhangqingya.cn_public.crt
SSLCertificateKeyFile /etc/httpd/conf/ssl/6547720_zhangqingya.cn.key
SSLCertificateChainFile /etc/httpd/conf/ssl/6547720_zhangqingya.cn_chain.crt                        
```
###### 启动服务
```
chkconfig php73-php-fpm on
chkconfig httpd  on
chkconfig mysqld on
systemctl restart php73-php-fpm
systemctl restart httpd 
```
###### 打开浏览器 http://本机IP

管理后台: http://本机IP/admin/login

默认用户名/密码: admin/admin

##### Ubuntu 20.04.3 LTS 
```
# mysql --version
mysql  Ver 8.0.27-0ubuntu0.20.04.1 for Linux on x86_64 ((Ubuntu))

# php -v
PHP 7.4.3 (cli) (built: Oct 25 2021 18:20:54) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
with Zend OPcache v7.4.3, Copyright (c), by Zend Technologies
```

###### 安装lamp:
```
apt-get update && apt install apache2 php php-mysql \
    php7.4-mbstring php7.4-curl mysql-server mysql-client -y 
```

###### 开启apache2 重写功能
```
a2enmod rewrite
cat >> /etc/apache2/sites-enabled/000-default.conf<<EOF
<VirtualHost _default_:443>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html
 
    SSLEngine on
    SSLCertificateFile /etc/apache2/ssl/zhangqingya.cn.cer
    SSLCertificateKeyFile /etc/apache2/ssl/zhangqingya.cn.key
    ErrorLog ${APACHE_LOG_DIR}/error_443.log
    CustomLog ${APACHE_LOG_DIR}/access_443.log combined 
    <Directory />
        Require all granted
    </Directory>
</VirtualHost>
<Directory /var/www/html/>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
EOF
service apache2 restart
```
###### 下载源码并拷贝至默认网站目录
```
cd /var/www/html
git clone https://github.com/osoulmate/Qianzhi.git 
cp -ra Qianzhi/* /var/www/html/
chown -R www-data:www-data /var/www/html/tmp
chown -R www-data:www-data /var/www/html/db
chown -R root:www-data /var/www/html/session
chmod -R 775 /var/www/html/tmp
chmod -R 775 /var/www/html/session
```
###### 配置mysql8密码
```
mysql -uroot
mysql> use mysql;
#修改root用户密码策略
mysql> update user set plugin='caching_sha2_password' where user='root';
mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'yourpassword';
mysql> FLUSH PRIVILEGES;
mysql> use qianzhi_db;
mysql> source /root/Qianzhi/db/qianzhi.sql;
mysql> Exit;
```
###### HTTPS配置
*免费证书申请*
1. 下载acme.sh
```
cd ~
git clone https://gitee.com/osoulmate/acme.sh.git
```
2. 安装配置acme.sh
```
cd acme.sh
./acme.sh --install -m askqingya@163.com
source /root/.bashrc
```
3. 申请证书
方法1：
```
acme.sh --issue --apache -d zhangqingya.cn
```
方法2：
```
export Ali_Key="youralikey"
export Ali_Secret="youralisecret"
acme.sh --issue --dns dns_ali --log -d zhangqingya.cn -d *.zhangqingya.cn
```
4. 安装证书
```
acme.sh  --installcert  -d  zhangqingya.cn   \
        --cert-file  /etc/apache2/ssl/zhangqingya.cn.cer  \
        --key-file   /etc/apache2/ssl/zhangqingya.cn.key \
        --fullchain-file /etc/apache2/ssl/fullchain.cer \
        --reloadcmd  "systemctl reload apache2"
```
##### Ubuntu 24.04 LTS 
以下内容引用自[系统极客](https://www.sysgeek.cn/install-php-8-ubuntu/)

1. 更新操作系统

- 开始之前，请确保你的 Ubuntu 24.04 LTS 系统已更新到最新版本。打开「终端」，输入以下命令来更新和升级软件包：
```
sudo apt update
```
2. 添加 PHP 软件源
- Ubuntu 24.04 LTS 默认的软件源中并没有旧版本的 PHP（比如 PHP 7.4），但我们可以通过添加知名的 Ondrej Sury PPA 来解决这个问题。Ondrej Sury 的 PHP PPA 为 Ubuntu 用户提供了多版本 PHP 选择，包括 PHP 5.6、PHP 7.x、PHP 8.x 以及大多数常用扩展。你还可以同时安装多个 PHP 版本，并在需要时进行切换。
```
sudo apt install ca-certificates apt-transport-https software-properties-common
```
- 接着，将 Ondrej 的 PPA 添加到你的系统中：
```
sudo add-apt-repository ppa:ondrej/php
```
- 最后，别忘了更新软件源列表，让系统「认识」新添加的 PPA：
```
sudo apt update
```
3. 安装 PHP 7.x
- 一切准备就绪，开始安装 PHP 7.x。例如安装 PHP 7.4，就在「终端」输入以下命令：
```
sudo apt install php7.4
```
- 安装完成后，别忘了验证一下是否安装成功。运行以下命令，检查 PHP 版本（记得替换成你实际安装的版本号哦）：
```
php7.4 --version
```

3.1 为 Nginx 安装 PHP 7.x FPM

*如果你的 Web 服务器是 Nginx，PHP-FPM 就是处理 PHP 文件的最佳搭档。接下来，我们看看如何为 Nginx 搭配 PHP 8.x FPM ：*

- 首先，安装 PHP 7.x FPM。这里以 PHP 7.4 为例：
```
sudo apt install php7.4-fpm
```
- 安装完成后，检查 PHP-FPM 服务是否正常工作：
```
systemctl status php7.4-fpm
```
- 根据你的实际情况，编辑 Nginx 的默认配置文件或虚拟主机配置文件。例如：
```
vi /etc/nginx/sites-available/default
```
- 在server块中添加（或编辑）以下内容，让 Nginx 通过 PHP-FPM 来处理.php文件：
```
location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
}
```
- 保存修改后，检查 Nginx 配置是否正确：
```
nginx -t
```
- 最后，重启 Nginx 让配置生效：
```
sudo systemctl restart nginx
```
3.2 为 Apache 安装 PHP 7.4

*如果你的 Web 服务器是 Apache，将 PHP 作为模块安装可以提高性能，PHP 解释器将直接嵌入到 Apache 中运行。下面，我们来看看如何为 Apache 安装 PHP 7.4 并完成配置：*

- 运行以下命令，将 PHP 7.4 作为 Apache 模块安装：
```
sudo apt install libapache2-mod-php7.4
```
- 安装完成后，重启 Apache 以加载新的 PHP 模块：
```
sudo systemctl restart apache2
```
4. 安装 PHP 扩展
*PHP 扩展可以为你的 PHP 环境提供额外的功能支持，比如数据库连接、图像处理、加密等。安装这些扩展也非常简单。下面我们来看具体操作。*
- 要安装 PHP 扩展，只需运行以下命令：
```
sudo apt install php7.4-[扩展名]
#记得将[扩展名]改成为你需要的具体扩展名称。例如，安装 MySQL 扩展：
sudo apt install php7.4-mysql php7.4-imap php7.4-ldap php7.4-xml php7.4-curl php7.4-mbstring php7.4-zip php7.4-redis
```
5. 随时切换 PHP 8.x 版本
*在同一台机器上，我们可以保留多个 PHP 版本，以便根据需要随时切换。接下来，我们将介绍如何使用update-alternatives工具来管理多个 PHP 版本。*
- 使用以下命令，查看当前系统中已安装的 PHP 版本：
```
sudo update-alternatives --config php
#运行后，你会看到一个类似下图的交互式提示菜单：

*表示当前启用的版本。
你可以通过输入对应的数字（比如1）来切换到 PHP 7.4。
```
- 如果你不想使用交互式提示，也可以直接运行以下命令切换到指定版本。例如，切换到 PHP 7.4：
```
update-alternatives --set php /usr/bin/php7.4
```