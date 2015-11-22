#CodeImg System

##Dependencies
  - chef-solo
  - ubuntu server 14.04 LTS

##Configuring
  1. clone repository to an ubuntu server with chef-solo installed
  2. set the run list to `recipe[codeimg]`
  3. converge the machine using the run list. chef will take care of the rest

###Configuring without chef-solo
  1. install dependencies 
  
  ```
  # apt-get install apache2 libapache2-mod-php5 rake php5-cli php5-json php5-ldap php5-gd php5-mysql php5-mysqlnd mysql-client mysql-server libfreetype6-dev libfreetype6
  # gem install highline
  ```
  2. add a site file to apache that points to the `www/codeimg` directory as the docroot
    - `AllowOverride` All needs to be enabled
    - The site should make use of SSL
  3. set up the database
  
  ```
  # mysql --defaults-file=/etc/mysql/debian.cnf -e "CREATE DATABASE codeimg;"
  # mysql --defaults-file=/etc/mysql/debian.cnf codeimg < codeimg/SCHEMA.sql
  # mysql --defaults-file=/etc/mysql/debian.cnf -e "GRANT ALL ON codeimg.* to 'codeimg'@'127.0.0.1' IDENTIFIED BY 'codeimg';" 
  ```
  4. Trust your LDAP cert if you're using self-signed
    1. add your LDAP cert to `/etc/ldap/certs/cert.pem`
    2. configure LDAP to trust this cert by adding this to the end of `/etc/ldap/ldap.conf`
    
    ```
    TLS_REQCERT never
    TLS_CACERT /etc/ldap/certs/cert.pem
    ```
    3. ensure that the cert is readable by apache
  5. run `rake` to fill in templated files used by the project, using defaults and overriding where neccesary

##Testing
1. Install [Vagrant](vagrantup.com)
2. Install [VirtualBox](virtualbox.org)
3. run `vagrant up`
  - This will set up a virtual test environment to be used with the codeimg system.
  - Chef will configure the virtual machine.
  - You can test the system by browsing to localhost:8080 on your machine.
