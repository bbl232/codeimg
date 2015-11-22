# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.provision "chef_solo" do |chef|
    chef.cookbooks_path = ["cookbooks"]
    chef.run_list = ["recipe[codeimg]"]
    chef.json = {
      "apache" => {
        "listen_ports" => ["80"]
      }
    }
  end
end
