include_recipe "apache2"

web_app "codeimg.me" do
  server_name "localhost"
  server_aliases ["*"]
  docroot "/vagrant/www/codeimg"
  cookbook "codeimg"
end

%w(rake libapache2-mod-php5 php5-cgi php5 php5-cli php5-json php5-ldap php5-gd php5-mysql mysql-server libfreetype6-dev libfreetype6).each do |p|
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
