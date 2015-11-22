=CODEIMG SYSTEM

==Dependencies
  - chef-solo
  - ubuntu server 14.04 LTS

==Configuring
  clone repository to an ubuntu server with chef-solo installed
  set the run list to "recipe[codeimg]"
  converge the machine using the run list. chef will take care of the rest

  If you have set up the server already and do not need chef to install dependencies (which can be found in the chef codeimg default recipe)
  then just run rake to be prompted for templated values that you need to fill in, or use the defaults.

  The database schema can be found in SCHEMA.sql and needs to be applied to a MySQL databse that this system will point to (configurable via rake)

==Testing
  Install vagrant (vagrantup.com)
  Install VirtualBox (virtualbox.org)

  run `vagrant up`

  This will set up a virtual test environment to be used with the codeimg system. Chef will configure the virtual machine.

  You can test the system by browsing to localhost:8080 on your machine.