require "rubygems"

begin
  require File.join(File.dirname(__FILE__), 'config/helpers/derb')
  require File.join(File.dirname(__FILE__), 'config/helpers/interactive_binding')
  require File.join(File.dirname(__FILE__), 'config/helpers/render_files')
#rescue Exception
end

hintsfile = ENV['RENDER_HINTS'] || File.join(File.dirname(__FILE__), 'config/defaultrenderhints.yml')

task :default do
  Rake::Task[:render_files].invoke("false")
end

task :render_files, [:use_default] do |t, args|
  args.with_defaults(:use_default => "false")
  binding = InteractiveBinding.new(hintsfile, args.use_default).get_binding
  projects = RenderFiles.find_projects(File.dirname(__FILE__))

  projects.each do |project|
    RenderFiles.render(project, binding)
  end
end
