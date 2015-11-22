include_recipe "apache2"

web_app "codeimg.me" do
  server_name "localhost"
  server_aliases ["*"]
  docroot "/vagrant/www"
  cookbook "codeimg"
end

%w(libapache2-mod-php5 php5 php5-cgi php5-cli php5-json php5-ldap php5-gd php5-mysql mysql-server libfreetype6-dev libfreetype6).each |p| do
   package p
end
