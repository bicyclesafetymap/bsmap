# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box     = "CentOS6.5"
  config.vm.box_url = "https://github.com/2creatives/vagrant-centos/releases/download/v6.5.3/centos65-x86_64-20140116.box"
  # config.vm.box_check_update = false

  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.

  config.vm.network "private_network", ip: "192.168.67.21"

  # chef
  config.omnibus.chef_version = :latest

  config.vm.synced_folder ".", "/vagrant",
    :owner => "vagrant", :group => "vagrant",
    :mount_options => ["dmode=777,fmode=777"]

  config.vm.provision :chef_solo do |chef|
    chef.cookbooks_path = ["cookbooks"]
    # chef.data_bags_path = ["data_bags"]
    # %w{yum-epel httpd httpd::php mysql mysql::create_db mysql::create_user virtualhosts vsftpd iptables}.each do |re|
    %w{yum-remi yum-epel httpd httpd::php55 mysql mysql::create_db mysql::create_user virtualhosts vsftpd iptables}.each do |re|
      chef.add_recipe re
    end

    chef.json = {
      "iptables"=> {
        "rule"=> [
          {"port"=> "21"},
          {"port"=> "80"},
          {"port"=> "3306"}
        ]
      },
      "mysql"=> {
        "root_password"=> "password!",
        "schema"=> ["bsmap"],
        "users"=> [
          {
            "name"=> "bsmapuser",
            "password"=> "bsmapuser!",
            "role"=> "admin",
            "permit_host"=> ["127.0.0.1", "localhost", "%"]
          }
        ],
        "max_allowed_packet"=> "4M"
      },
      "virtualhosts"=> {
        "rotate"=> 4,
        "vh_list"=> [
          {
            "name"=> "bsmap",
            "param"=> {
              "template"=> "vagrant",
              "documentroot" => "/vagrant",
              "email"=> "hoge@youroriginal.host",
              "ipaddr"=> "192.168.67.21",
              "fqdn"=> "hoge.bsmap.jp",
              "ftp_id"=> "bsmap_user",
              "ftp_password"=> "bsmap_userpass",
              "basic_id"=> "bsmap.basic.author",
              "basic_password"=> "bsmap.basic.pass"
            }
          }
        ]
      }
    }
  end

end
