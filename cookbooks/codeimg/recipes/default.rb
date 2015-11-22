include_recipe "apache2"

web_app "codeimg.me" do
  server_name "localhost"
  server_aliases ["*"]
  docroot "/vagrant/www"
  cookbook "vandenberk"
end

package "php5-cli"
package "libapache2-mod-php5"
package "libfreetype6"
package "libfreetype6-dev"
package "php5-gd"
