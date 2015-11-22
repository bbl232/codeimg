require 'fileutils'

class RenderFiles
  # Recursively find all the projects relative to the root.
  def self.find_projects(root)
    result = [root]

    submodules_dir = File.join(root, "submodules")

    if File.directory? submodules_dir
      Dir.foreach(submodules_dir) do |submodule|
        next if submodule.start_with?('.')

        result.concat(find_projects(File.join(submodules_dir, submodule)))
      end
    end

    return result
  end

  # Fill in all the template files in the project using the binding.
  def self.render(project, binding)
    DErb.erbize(File.join(project, "config", "templates", "app"), binding) do |file, contents|
      FileUtils.mkdir_p(File.dirname(File.join(project, file))) unless File.exists?(File.dirname(File.join(project, file)))

      File.open(File.join(project, file), 'w') do |out|
        out.write(contents)
      end
    end
  end
end
