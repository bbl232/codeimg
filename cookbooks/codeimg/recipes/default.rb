include_recipe "apache2"
include_recipe "apache2::mod_php5"
include_recipe "apache2::mpm_prefork"

web_app "codeimg.me" do
  server_name "localhost"
  server_aliases ["*"]
  docroot "/vagrant/www/codeimg"
  cookbook "codeimg"
  allow_override "All"
end

%w(rake php5-cli php5-json php5-ldap php5-gd php5-mysql php5-mysqlnd mysql-client mysql-server libfreetype6-dev libfreetype6).each do |p|
   package p
end

gem_package "highline"

directory "/etc/ldap/certs" do
  owner "root"
  group "root"
  mode 0755
end

cookbook_file "/etc/ldap/certs/guelph.pem" do
  owner "root"
  group "root"
  mode 0644
  source "guelph.pem"
end

cookbook_file "/etc/ldap/ldap.conf" do
  owner "root"
  group "root"
  mode 0644
  source "ldap.conf"
  notifies :restart, "service[apache2]", :delayed
end

bash "import_schema" do
  cwd "/etc/mysql"
  user "root"
  code <<-EOH
    mysql --defaults-file=/etc/mysql/debian.cnf -e "CREATE DATABASE codeimg;"
    mysql --defaults-file=/etc/mysql/debian.cnf codeimg < /vagrant/SCHEMA.sql
    mysql --defaults-file=/etc/mysql/debian.cnf -e "GRANT ALL ON codeimg.* to 'codeimg'@'127.0.0.1' IDENTIFIED BY 'codeimg';"
    echo date > /etc/mysql/LAST_IMPORT
  EOH
  not_if do ::File.exists?("/etc/mysql/LAST_IMPORT") end
end

bash "rake_codeimg" do
  cwd "/vagrant"
  code <<-EOH
    rake render_files[true]
  EOH
  not_if do ::File.exists?("/vagrant/www/conifg/config.php") end
end

